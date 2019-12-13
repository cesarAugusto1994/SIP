<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training\{Team, Course};
use App\Models\Training\Team\Employee as TeamEmployee;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use App\Models\Client\Employee;
use App\Models\Client as Company;
use App\Models\People;
use App\User;
use PDF;
use DateTime, DatePeriod, DateInterval;
use App\Models\ServiceOrder\ServiceOrder;
use App\Models\ServiceOrder\ServiceOrder\Training\Course as ServiceOrderTrainingCourse;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teams = Team::orderByDesc('start');

        if(!$request->has('find')) {
            $teams->whereIn('status', ['RESERVADO', 'EM ANDAMENTO']);
        }

        if($request->filled('code')) {
            $teams->where('id', $request->get('code'));
        } else {

          if($request->filled('status')) {
              $teams->where('status', $request->get('status'));
          }

          if($request->filled('teacher_id')) {
              $teams->where('teacher_id', $request->get('teacher_id'));
          }

          if($request->filled('course_id')) {
              $teams->where('course_id', $request->get('course_id'));
          }

          if($request->filled('start')) {
              $start = \DateTime::createFromFormat('d/m/Y', $request->get('start'));
              $teams->where('start', '>=', $start->format('Y-m-d') . ' 00:00:00');
          }

          if($request->filled('end')) {
              $end = \DateTime::createFromFormat('d/m/Y', $request->get('end'));
              $teams->where('start', '<=', $end->format('Y-m-d') . ' 23:59:59');
          }
        }

        $quantity = $teams->count();

        $teams = $teams->paginate();

        foreach ($request->all() as $key => $value) {
            $teams->appends($key, $value);
        }

        $teachers = Helper::usersByOccupation(28);

        return view('training.teams.index', compact('teams', 'quantity', 'teachers'));
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
    public function create(Request $request)
    {
        $companies = Helper::companiesWhereHasEmployees();
        $courses = Helper::courses();
        $teachers = Helper::usersByOccupation(28);

        $message = "";

        if($request->has('service_order')) {

            $serviceOrder = ServiceOrder::uuid($request->get('service_order'));

            $message = "Treinamento referente à OS #" . str_pad($serviceOrder->id, 6, "0", STR_PAD_LEFT) . "<br/>
            Cliente: " . $serviceOrder->client->name . "
            ";

        }

        return view('training.teams.create', compact('companies', 'courses', 'teachers', 'message'));
    }

    public function certified($id)
    {
        $teamEmployee = TeamEmployee::uuid($id);
        $employee = $teamEmployee->employee;
        $team = $teamEmployee->team;

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($team->start, $interval, $team->end);

        $arrayDate = [];

        $yearString = $monthString = $textDate = "";

        foreach ($period as $dt) {
            $monthString = Helper::convertMonths($dt->format('m'));
            $yearString = $dt->format('Y');
            $arrayDate[$monthString][] = $dt->format('d');
        }

        foreach ($arrayDate as $key => $item) {
          $stringA = implode(', ', $item);
          $textDate .= $stringA . ' de ' . $key . ' ';
        }

        $textDate .= 'de ' . $yearString;

        return view('training.certified', compact('team', 'employee', 'textDate', 'teamEmployee'));
    }

    public function certifiedCompany($id)
    {
        $team = Team::uuid($id);

        $companies = [];

        foreach ($team->employees as $key => $employee) {

            if($employee->status != 'PRESENTE') {
                continue;
            }

            $cnpj = Helper::formatCnpjCpf($employee->employee->company->document);
            $companies[$employee->employee->company->name . ', CNPJ '. $cnpj][] = $employee->employee->name;
        }

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($team->start, $interval, $team->end);

        $arrayDate = [];

        $yearString = $monthString = $textDate = "";

        foreach ($period as $dt) {
            $monthString = Helper::convertMonths($dt->format('m'));
            $yearString = $dt->format('Y');
            $arrayDate[$monthString][] = $dt->format('d');
        }

        foreach ($arrayDate as $key => $item) {
          $stringA = implode(', ', $item);
          $textDate .= $stringA . ' de ' . $key . ' ';
        }

        $textDate .= 'de ' . $yearString;

        return view('training.certified-company', compact('team', 'textDate', 'companies'));
    }

    public function certifiedTeam($id)
    {
        $team = Team::uuid($id);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($team->start, $interval, $team->end);

        $arrayDate = [];

        $yearString = $monthString = $textDate = "";

        foreach ($period as $dt) {
            $monthString = Helper::convertMonths($dt->format('m'));
            $yearString = $dt->format('Y');
            $arrayDate[$monthString][] = $dt->format('d');
        }

        foreach ($arrayDate as $key => $item) {
          $stringA = implode(', ', $item);
          $textDate .= $stringA . ' de ' . $key . ' ';
        }

        $textDate .= 'de ' . $yearString;

        return view('training.certified-team', compact('team', 'textDate'));
    }

    public function showCertified($id)
    {
        $teamEmployee = TeamEmployee::uuid($id);
        $employee = $teamEmployee->employee;
        $team = $teamEmployee->team;

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($team->start, $interval, $team->end);

        $arrayDate = [];

        $yearString = $monthString = $textDate = "";

        foreach ($period as $dt) {
            $monthString = Helper::convertMonths($dt->format('m'));
            $yearString = $dt->format('Y');
            $arrayDate[$monthString][] = $dt->format('d');
        }

        foreach ($arrayDate as $key => $item) {
          $stringA = implode(', ', $item);
          $textDate .= $stringA . ' de ' . $key . ' ';
        }

        $textDate .= 'de ' . $yearString;

        return view('training.certified', compact('team', 'employee', 'textDate', 'teamEmployee'));
    }

    public function start($id, Request $request)
    {
        $team = Team::uuid($id);

        $preReservados = $team->employees->where('status', 'AGENDADO');

        if($preReservados->isNotEmpty()) {

          notify()->flash('Aula não iniciada!', 'warning', [
            'text' => 'Informe a presença dos participantes.'
          ]);

          return back();

        }

        $team->status = 'EM ANDAMENTO';
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

          $team->employees->map(function($employee) {
              if($employee->status == 'PRESENTE') {
                  $employee->approved = true;
                  $employee->save();
              }
          });

          $team->status = 'FINALIZADA';
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

    public function presenceList($id, Request $request)
    {
        $team = Team::uuid($id);

        $diffDays = 0;

        if($team->start) {
          $diffDays = $team->end->diff($team->start)->days;
        }

        $interval = DateInterval::createFromDateString('1 day');
        $periodDate = new DatePeriod($team->start, $interval, $team->end);

        $user = $request->user();

        $id = str_pad($team->id, 6, "0", STR_PAD_LEFT);
        $title = "Lista de Presenca:$id:";

        $pdf = PDF::loadView('training.teams.presence', compact('team', 'diffDays', 'periodDate'));

        $stylePdf = $pdf->getDomPDF();
        $canvas = $stylePdf ->get_canvas();
        $canvas->page_text(520, 2, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(255, 255, 255));

        return $pdf->stream($title. ".pdf");
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

            $teamEmployee = TeamEmployee::uuid($employee);

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
        $employee = TeamEmployee::uuid($id);
        return view('training.teams.employee.status', compact('employee'));
    }

    public function employeeStatusUpdate($id, Request $request)
    {
        $data = $request->request->all();

        $teamEmployee = TeamEmployee::uuid($id);
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

          $teamEmployee = TeamEmployee::uuid($id);
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

        if($request->has('service_order_course')) {
            $serviceOrderCourse = ServiceOrderTrainingCourse::uuid($request->get('service_order_course'));
            $serviceOrderCourse->team_id = $team->id;
            $serviceOrderCourse->save();
        }

        if($request->has('employees')) {

          $employees = Employee::whereIn('uuid', $data['employees'])->get();

          foreach ($employees as $key => $employee) {
            TeamEmployee::create([
              'team_id' => $team->id,
              'employee_id' => $employee->id,
            ]);
          }

        }

        return redirect()->route('teams.show', $team->uuid);
    }

    public function duplicate($id, Request $request)
    {
        try {
          $team = Team::uuid($id);

          $startDate = $team->start;
          $endDate = $team->end;

          $newTeam = $team->replicate();
          $TeamEmployee = $team->employees;

          $newTeam->start = $startDate->modify('+1 day');
          $newTeam->end = $endDate->modify('+1 day');
          $newTeam->save();

          foreach ($TeamEmployee as $key => $employee) {
            TeamEmployee::create([
              'team_id' => $newTeam->id,
              'employee_id' => $employee->employee->id,
            ]);
          }

          return response()->json([
            'success' => true,
            'message' => 'Uma nova turma foi criada.',
            'route' => route('teams.show', ['id' => $newTeam->uuid])
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'route' => null
          ]);
        }
    }

    public function list()
    {
        $user = auth()->user();

        $teams = Team::all();

        $cardCollor = "#1ab394";
        $editable = false;

        $data = [];

        foreach ($teams as $key => $team) {
          /*switch($team->course->type) {
            case 'Treinamento':
              $cardCollor = "#23c6c8";
              $editable = true;
            break;
            case 'Palestra':
              $cardCollor = "#f8ac59";
              $editable = true;
            break;
            default:
              $cardCollor = "#0ac282";
            break;
          }*/

          if($team->start > now()) {
              $editable = true;
          }

          $cardCollor = $team->course->color;

          if($team->status != 'RESERVADO') {
            $editable = false;
          }

          $title = $team->course->type . ' - ' . $team->course->title . ' - Instrutor(a): ' . $team->teacher->person->name;

          $data[] = [
              'id' => $team->id,
              'uuid' => $team->uuid,
              'course_id' => $team->course_id,
              'title' => $title,
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

    public function updateScheduleDate(Request $request)
    {
        $data = $request->request->all();

        try {

          $team = Team::uuid($data['id']);

          $start = DateTime::createFromFormat('d/m/Y H:i', $data['start']);
          $end = DateTime::createFromFormat('d/m/Y H:i', $data['end']);

          $data['start'] = $start;
          $data['end'] = $end;

          $team->update($data);

          return response()->json([
            'success' => true,
            'message' => 'Data de Agendamento atualizada com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage()
          ]);
        }
    }

    public function addEmployes($id, Request $request)
    {
        $data = $request->request->all();

        if(count($data['employees']) <= 0) {
            return back();
        }

        $team = Team::uuid($id);

        /*if($team->vacancies < ($team->employees->count() + count($data['employees']))) {

            notify()->flash('Limite de vagas excedido', 'error', [
              'text' => 'O número de funcionários excede o limite de usuários.'
            ]);

            return back();
        }*/

        foreach ($data['employees'] as $key => $employeeID) {

          $employee = Employee::uuid($employeeID);

          $hasEmployee = TeamEmployee::where('team_id', $team->id)->where('employee_id', $employee->id)->first();

          if($hasEmployee) {
              continue;
          }

          TeamEmployee::create([
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
        $courses = Helper::courses();
        $teachers = Helper::usersByOccupation(28);

        $hasAgendado = $team->employees->where('status', 'AGENDADO')->first();

        $diffDays = 0;

        if($team->start) {
          $diffDays = $team->end->diff($team->start)->days;
        }

        return view('training.teams.show', compact('team', 'diffDays', 'teamCode', 'courses', 'teachers', 'hasAgendado'));
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

          $employee = TeamEmployee::uuid($employee);
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
