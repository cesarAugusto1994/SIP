<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training\{Team, Course};
use App\Models\Training\Team\Employee as TeamEmployees;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use App\Models\Client\Employee;
use App\Models\Client as Company;
use App\Models\People;
use App\User;
use DateTime;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();
        return view('training.teams.index', compact('teams'));
    }

    public function schedule()
    {
        $courses = Helper::courses();
        $teachers = Helper::usersByOccupation(28);
        return view('training.teams.schedule', compact('courses', 'teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Helper::companiesWhereHasEmployees();
        $courses = Helper::courses();
        $teachers = Helper::usersByOccupation(28);

        return view('training.teams.create', compact('companies', 'courses', 'teachers'));
    }

    public function certified($id, $employee)
    {
        $employee = Employee::uuid($employee);
        $team = Team::uuid($id);
        return view('training.certified', compact('team', 'employee'));
    }

    public function start($id, Request $request)
    {
        $team = Team::uuid($id);

        $preReservados = $team->whereHas('employees', function($query) {
            $query->where('status', 'AGENDADO');
        })->first();

        if($preReservados) {

          notify()->flash('Aula não iniciada!', 'warning', [
            'text' => 'Informe a presença dos participantes.'
          ]);

          return back();

        }

        $team->Status = 'EM ANDAMENTO';
        $team->save();

        notify()->flash('Curso em Andamento!', 'success', [
          'text' => 'O Curso foi iniciado com sucesso'
        ]);

        return redirect()->route('teams.show', $team->uuid);

    }

    public function finish($id, Request $request)
    {
        try {

          $team = Team::uuid($id);

          $preReservados = $team->whereHas('employees', function($query) {
              $query->where('status', 'PRESENTE');
          })->first();

          if(!$preReservados) {

            return response()->json([
              'success' => false,
              'message' => 'Informe a presença dos participantes.'
            ]);

          }

          $team->Status = 'FINALIZADA';
          $team->save();

          return response()->json([
            'success' => true,
            'message' => 'O Curso foi Finalizado com sucesso, os certificados podem ser gerados.'
          ]);
        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado, o suporte já foi informado sobre o ocorrido'
          ]);
        }
    }

    public function presenceList($id)
    {
        $team = Team::uuid($id);
        return view('training.teams.presence', compact('team'));
    }

    public function uploadPresenceList($id, Request $request)
    {
        $team = Team::uuid($id);

        if ($request->hasFile('presence_list')) {

          $path = $request->presence_list->store('teams');
          $data['presence_list'] = $path;

          $team->update($data);
        }

        notify()->flash('Lista de Preseça Enviada', 'success', [
          'text' => 'A Lista de Preseça Enviada e Salva com sucesso.'
        ]);

        return back();
    }

    public function previewPresenceList($id)
    {
        $team = Team::uuid($id);

        $link = $team->presence_list;

        $file = \Storage::exists($link) ? \Storage::get($link) : false;

        if(!$file) {
          notify()->flash('Lista de Preseça Não Encontrada', 'error', [
            'text' => 'A Lista de Preseça errornão foi Encontrada.'
          ]);
          return back();
        }

        $mimetype = \Storage::disk('local')->mimeType($link);

        return response($file, 200)->header('Content-Type', $mimetype);
    }

    public function employeePresence($id, Request $request)
    {
        $data = $request->request->all();

        $team = Team::uuid($id);

        foreach ($data['employees'] as $key => $employee) {

            $teamEmployee = TeamEmployees::uuid($employee);

            $status = 'FALTA';

            if($request->has('employee-'.$employee)) {
                $status = 'PRESENTE';
            }

            $teamEmployee->status = $status;
            $teamEmployee->save();

        }

        notify()->flash('Preseça Confirmada', 'success', [
          'text' => 'A presença dos alunos foi confirmada.'
        ]);

        return back();
    }

    public function employeeStatus($id)
    {
        $employee = TeamEmployees::uuid($id);
        return view('training.teams.employee.status', compact('employee'));
    }

    public function employeeStatusUpdate($id, Request $request)
    {
        $data = $request->request->all();

        $teamEmployee = TeamEmployees::uuid($id);
        $teamEmployee->status = $data['status'];
        $teamEmployee->save();

         notify()->flash('Presença Confirmada', 'success', [
          'text' => 'O status foi atualizado com sucesso.'
        ]);

        return redirect()->route('teams.show', $teamEmployee->team->uuid);
    }

    public function employeeChangeStatus($id, Request $request)
    {
        try {

          $status = $request->get('status');

          $teamEmployee = TeamEmployees::uuid($id);
          $teamEmployee->status = $status;
          $teamEmployee->save();
          //$teamEmployee->delete();

          return response()->json([
            'success' => true,
            'message' => 'Situação alterada para ' . $status . ' com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage()
          ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->request->all();

        $course = Course::uuid($data['course_id']);
        $teacher = User::uuid($data['teacher_id']);

        $data['course_id'] = $course->id;
        $data['teacher_id'] = $teacher->id;

        $start = DateTime::createFromFormat('d/m/Y H:i', $data['start']);
        $end = DateTime::createFromFormat('d/m/Y H:i', $data['end']);

        $data['start'] = $start;
        $data['end'] = $end;

        $team = Team::create($data);

        if($request->has('employees')) {

          $employees = Employee::whereIn('uuid', $data['employees'])->get();

          foreach ($employees as $key => $employee) {
            TeamEmployees::create([
              'team_id' => $team->id,
              'employee_id' => $employee->id,
            ]);
          }

        }

        return redirect()->route('teams.show', $team->uuid);
    }

    public function list()
    {
        $user = auth()->user();

        $teams = Team::all();

        $cardCollor = "#1ab394";
        $editable = false;

        $data = [];

        foreach ($teams as $key => $team) {
          switch($team->course_id) {
            case 1:
              $cardCollor = "#23c6c8";
              $editable = true;
            break;
            case 2:
              $cardCollor = "#f8ac59";
              $editable = true;
            break;
            case 3:
              $cardCollor = "#0ac282";
            break;
            default:
              $cardCollor = "#0ac282";
            break;
          }

          $data[] = [
              'id' => $team->id,
              'uuid' => $team->uuid,
              'course_id' => $team->course_id,
              'title' => $team->course->title,
              'description' => $team->course->description,
              'start' => $team->start ? $team->start->format('Y-m-d H:i') : null,
              'end' => $team->end ? $team->end->format('Y-m-d H:i') : null,
              'color' => $cardCollor,
              'editable' => $editable,
              'route' => route('teams.show', $team->uuid),
          ];
        }

        return json_encode($data);
    }

    public function addEmployes($id, Request $request)
    {
        $data = $request->request->all();

        if(count($data['employees']) <= 0) {
            return back();
        }

        $team = Team::uuid($id);

        if($team->vacancies < ($team->employees->count() + count($data['employees']))) {

            notify()->flash('Limite de vagas excedido', 'error', [
              'text' => 'O número de funcionários excede o limite de usuários.'
            ]);

            return back();
        }

        foreach ($data['employees'] as $key => $employeeID) {

          $employee = Employee::uuid($employeeID);

          $hasEmployee = TeamEmployees::where('team_id', $team->id)->where('employee_id', $employee->id)->first();

          if($hasEmployee) {
              continue;
          }

          TeamEmployees::create([
            'team_id' => $team->id,
            'employee_id' => $employee->id,
          ]);
        }

        notify()->flash('Feito', 'success', [
          'text' => 'Participantes adicionados com sucesso.'
        ]);

        return redirect()->route('teams.show', $team->uuid);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::uuid($id);

        $teamCode = Helper::Initials($team->course->title) . $team->id . '-'.$team->start->format('d-m-y');
        $companies = Helper::companiesWhereHasEmployees();
        $employeesSelected = $team->employees->pluck('employee.id')->toArray();
        $courses = Helper::courses();
        $teachers = Helper::usersByOccupation(28);

        $hasAgendado = $team->employees->where('status', 'AGENDADO')->first();

        return view('training.teams.show', compact('team', 'teamCode', 'companies', 'courses', 'teachers', 'employeesSelected', 'hasAgendado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Team::uuid($id);

        $companies = Helper::companiesWhereHasEmployees();
        $courses = Helper::courses();
        $teachers = Helper::usersByOccupation(28);

        return view('training.teams.edit', compact('team', 'companies', 'courses', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $team = Team::uuid($id);

        $data = $request->request->all();

        $course = Course::uuid($data['course_id']);
        $teacher = User::uuid($data['teacher_id']);

        $data['course_id'] = $course->id;
        $data['teacher_id'] = $teacher->id;

        $start = DateTime::createFromFormat('d/m/Y H:i', $data['start']);
        $end = DateTime::createFromFormat('d/m/Y H:i', $data['end']);

        $data['start'] = $start;
        $data['end'] = $end;

        $team->update($data);

        notify()->flash('Sucesso', 'success', [
          'text' => 'Turma atualizada com sucesso.'
        ]);

        return redirect()->route('teams.show', $team->uuid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function destroyEmployes($id, $employee, Request $request)
    {
        try {

          $team = Team::uuid($id);

          if($team->employees->count() == 1) {
            return response()->json([
              'success' => false,
              'message' => 'Não é possivel remover o único aluno da turma, favor finalizar a aula.'
            ]);
          }

          $employee = TeamEmployees::uuid($employee);
          $employee->delete();

          return response()->json([
            'success' => true,
            'message' => 'Funcionário removido com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage()
          ]);
        }
    }
}
