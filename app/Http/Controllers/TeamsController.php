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
        $courses = Course::where('active', true)->get();
        $teachers = People::where('occupation_id', 28)->get();
        return view('training.teams.schedule', compact('courses', 'teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::whereHas('employees')->get();
        $courses = Course::where('active', true)->get();
        $teachers = People::where('occupation_id', 28)->where('active', true)->get();
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

        /*if($team->start > now()) {

          notify()->flash('Aula não iniciada!', 'warning', [
            'text' => 'A data de início deve ser igual a data agendada.'
          ]);

          return back();

        }*/

        $preReservados = $team->whereHas('employees', function($query) {
            $query->where('status', 'AGENDADO');
        })->get();

        if($preReservados) {

          notify()->flash('Aula não iniciada!', 'warning', [
            'text' => 'Informe a presença dos participantes.'
          ]);

          return back();

        }

        dd($preReservados);

        //ENUM('RESERVADO', 'EM ANDAMENTO', 'FINALIZADA', 'CANCELADA')

        $team->Status = 'EM ANDAMENTO';
        $team->save();

        notify()->flash('Aula em Andamento!', 'success', [
          'text' => 'A Aula foi iniciada com sucesso'
        ]);

        return redirect()->route('teams.show', $team->uuid);

        //dd($teams);
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

        //$data['start'] = \DateTime::createFromFormat('d/m/Y', $data['start']);
        //$data['end'] = \DateTime::createFromFormat('d/m/Y', $data['end']);

        $team = Team::create($data);

        if($request->has('employees')) {

          foreach ($data['employees'] as $key => $employeeID) {
            TeamEmployees::create([
              'team_id' => $team->id,
              'employee_id' => $employeeID,
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
          TeamEmployees::create([
            'team_id' => $team->id,
            'employee_id' => Employee::uuid($employeeID)->id,
          ]);
        }

        notify()->flash('Feito', 'success', [
          'text' => 'Funcionários adicionados com sucesso.'
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

        $companies = Company::whereHas('employees')->get();
        $employeesSelected = $team->employees->pluck('employee.id')->toArray();

        $courses = Course::where('active', true)->get();
        //$teachers = People::where('occupation_id', 9)->get();
        $teachers = People::where('occupation_id', 28)->where('active', true)->get();

        return view('training.teams.show', compact('team', 'teamCode', 'companies', 'courses', 'teachers', 'employeesSelected'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        //$data['start'] = \DateTime::createFromFormat('d/m/Y', $data['start']);
        //$data['end'] = \DateTime::createFromFormat('d/m/Y', $data['end']);

        $team->update($data);

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
