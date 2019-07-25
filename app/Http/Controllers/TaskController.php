<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\{Task, Department, Mapper};
use App\Models\Task\{Message, Log, Delay, Pause, Archive as FileUpload};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Request as Req;
use Storage;

class TaskController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::where('id', '>', 0)->get();

        if(!\Auth::user()->isAdmin()) {
            $tasks->where('user_id', \Auth::user()->id);
        }

        if($request->filled('status')) {
            $status = $request->get('status');
            $tasks = $tasks->where('status_id', $status);
        }

        if($request->filled('severity')) {
            $priority = $request->get('severity');
            $tasks = $tasks->where('severity', $priority);
        }

        if($request->filled('urgency')) {
            $priority = $request->get('urgency');
            $tasks = $tasks->where('urgency', $priority);
        }

        if($request->filled('trend')) {
            $priority = $request->get('trend');
            $tasks = $tasks->where('trend', $priority);
        }

        if($request->filled('date')) {
            $date = $request->get('date');
            $tasks = $tasks->filter(function($task, $key) use ($date) {

              $datePeriod = now()->subDays(0);

              if($date == 'hoje') {
                  return $task->created_at > now()->setTime(0,0,0) &&
                  $task->created_at < now()->setTime(23,59,59);
              } elseif($date == 'ontem') {
                  return $task->created_at > now()->subDays(1)->setTime(0,0,0) &&
                  $task->created_at < now()->subDays(1)->setTime(23,59,59);
              } elseif($date == 'semana') {
                  return $task->created_at > now()->subDays(7)->setTime(0,0,0) &&
                  $task->created_at < now()->setTime(23,59,59);
              } elseif($date == 'mes') {
                  return $task->created_at > now()->subDays(30)->setTime(0,0,0) &&
                  $task->created_at < now()->setTime(23,59,59);
              } elseif($date == 'ano') {
                  return $task->created_at > now()->subDays(365)->setTime(0,0,0) &&
                  $task->created_at < now()->setTime(23,59,59);
              } elseif($date == 'recente') {
                  return $task->created_at > now()->subHours(2)->setTime(0,0,0) &&
                  $task->created_at < now()->setTime(23,59,59);
              }

            });
        }

        if($request->filled('user')) {
            $user = $request->get('user');
            $tasks = $tasks->where('user_id', $user);
        }

        //$tasks = $tasks->paginate();

        return view('tasks.index')->with('tasks', $tasks);
    }

    public function calendar()
    {
        $tasks = Task::all();

        return view('tasks.calendar')
        ->with('tasks', $tasks);
    }

    public function getTasks()
    {
        $tasks = Task::where('status_id', 1)->get();

        $dados = [];

        $date = new \DateTime('now');

        foreach ($tasks as $task) {

          $inter = $date;
          $end = $inter->modify("+" . $task->time . " minutes");

          $dados[] = [
            'nome' => $task->description,
            'start' => $date->format('Y-m-d H:i'),
            'end' => $end->format('Y-m-d H:i')
          ];
        }

        return json_encode($dados);
    }

    public function showBoard()
    {
        return view('tasks.board')->with('tasks', Task::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('tasks.create');
    }

    public static function hourToMinutes($hours)
    {
        $tempo = \DateTime::createFromFormat('H:i', $hours);

        $hora = $tempo->format('H');
        $minutos = $tempo->format('i');

        $time = $minutos;

        if (!empty($hora)) {
            $time += $hora*60;
        }

        return $time;
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

        $validator = \Illuminate\Support\Facades\Validator::make($data, [
          'description' => 'required',
          'user_id' => 'required',
          'time' => 'required',
          'time_type' => 'required',
          'severity' => 'required',
          'urgency' => 'required',
          'trend' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data['status_id'] = Task::STATUS_PENDENTE;
        $data['user_id'] = Auth::user()->id;

        $task = Task::create($data);

        Log::create([
          'task_id' => $task->id,
          'user_id' => Auth::user()->id,
          'message' => 'Criou a tarefa ' . $task->name
        ]);

        //flash('Nova tarefa adicionada com sucesso.')->success()->important();
        return redirect()->route('tasks.index');
    }

    public function upload(Request $request, $id)
    {
        $task = Task::uuid($id);

        if ($request->hasFile('file') && $request->file('file')->isValid()) {

            $file = $request->file;
            $name = $file->getClientOriginalName();
            $size = $request->file->getSize();
            $path = $file->store('tasks');

            FileUpload::create([
                'task_id' => $task->id,
                'filename' => $name,
                'path' => $path,
                'size' => $size,
                'user_id' => $request->user()->id,
            ]);
        }

        notify()->flash('Upload com sucesso', 'success', [
          'text' => 'O upload do arquivo foi realizado com sucesso.'
        ]);

        return redirect()->route('tasks.show', $task->uuid);

    }

    public function preview($id)
    {
        $file = FileUpload::uuid($id);

        $link = $file->path;

        $file = Storage::exists($link) ? Storage::get($link) : false;

        if(!$file) {
          $file = null;
        }

        $mimetype = Storage::disk('local')->mimeType($link);

        return response($file, 200)->header('Content-Type', $mimetype);
    }

    public function download($id)
    {
        $file = FileUpload::uuid($id);

        if(!Storage::exists($file->path)) {
            notify()->flash('Arquivo não encontrado', 'error', [
              'text' => 'Download Indisponível: Este arquivo não foi encontrado nesta pasta.'
            ]);
            return back();
        }

        return Storage::download($file->path);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {

            $task = Task::uuid($id);

            //$horaAtual = now();
            //$remainTime = $task->begin;

            //$diff = $horaAtual->diff($horaCorte);
            //$segundos = $diff->s + ($diff->i * 60) + ($diff->h * 60);
            //$remainTime = ($task->time*60) - $segundos;

            $taskPause = Pause::where('task_id', $task->id)->first();

            if(!empty($taskPause)) {

              if(empty($taskPause->end)) {
                $remainTime = $horaAtual->diff(new \DateTime($taskPause->begin));
              } else {
                $base = new \DateTime($taskPause->end);
                $remainTime = $base->diff(new \DateTime($taskPause->begin));
              }
              $segundos2 = $diff2->s + ($diff2->i * 60) + ($diff2->h * 60 * 60);
              $remainTime = $remainTime + $segundos2;
            }

            $gut = ($task->severity * $task->urgency * $task->trend);

            if (Req::get('status') == Task::STATUS_EM_ANDAMENTO && $task->status_id != Task::STATUS_EM_ANDAMENTO) {

                if($task->mapper && $task->mapper->active != 1) {
                    return redirect()->back()->with('message', 'Esta tarefa Pertence a um mapeamento, deve primeiro iniciá-lo.');
                }

                $task->status_id = Task::STATUS_EM_ANDAMENTO;
                $task->begin = now();
                $task->save();

                $log = new Log();
                $log->task_id = $task->id;
                $log->user_id = Auth::user()->id;
                $log->message = 'Alterou o status da tarefa ' . $task->name . ' para Em Andamento.';
                $log->save();

                return redirect()->route('tasks.show', ['id' => $task->uuid]);

            } elseif (Req::get('status') == Task::STATUS_FINALIZADO && $task->status_id != Task::STATUS_FINALIZADO) {

                $task->status_id = Task::STATUS_FINALIZADO;
                $task->end = new \DateTime('now');
                $horaInicio = new \DateTime($task->begin);
                $diff = $task->end->diff($horaInicio);
                $minutos = $diff->i + ($diff->h * 60);

                $task->spent_time = $minutos;

                $task->save();

                $log = new Log();
                $log->task_id = $task->id;
                $log->user_id = Auth::user()->id;
                $msg = 'Alterou o status da tarefa ' . $task->name . ' para Finalizado.';
                $log->message = $msg;
                $log->save();

                return redirect()->route('tasks.show', ['id' => $task->uuid]);
            }

            if (Req::get('cancel')) {
                $task->status_id = Task::STATUS_CANCELADO;
                $task->begin = $task->end = new \DateTime('now');
                $task->save();

                $log = new Log();
                $log->task_id = $task->id;
                $log->user_id = Auth::user()->id;
                $log->message = 'Alterou o status da tarefa ' . $task->name . ' para Cancelado.';
                $log->save();

                return redirect()->route('tasks.show', ['id' => $task->uuid]);
            }

             if (Req::has('duplicate')) {

                $user = Auth::user()->isAdmin() ? $task->user_id : Auth::user()->id;

                $data = [
                    'name' => $task->name,
                    'description' => $task->description,
                    'user_id' => $user,
                    'frequency' => $task->frequency,
                    'time' => $task->time,
                    'client_id' => $task->client_id,
                    'severity' => $task->severity,
                    'urgency' => $task->urgency,
                    'trend' => $task->trend,
                    'status_id' => Task::STATUS_PENDENTE,
                    'created_by' => Auth::user()->id,
                ];

                $newTask = Task::create($data);

                $this->log($task, 'Duplicou a tarefa ' . $task->name);

                $this->log($newTask, 'Criou a tarefa ' . $newTask->name);

                return redirect()->route('tasks.show', ['id' => $newTask->uuid]);
            }

            $taskDelay = Delay::where('task_id', $task->id)->first();
            $pausedTask = Pause::where('task_id', $task->id)->where("end", null)->first();

        } catch(Exception $e) {

            return response()->view('errors.custom', [], 404);

        }

        $remainTime = null;

        if($task->begin) {

          if($task->time_type == 'day') {
              $remainTime = $task->begin->addDays($task->time);
          } elseif ($task->time_type == 'hour') {
              $remainTime = $task->begin->addHours($task->time);
          } elseif ($task->time_type == 'minute') {
              $remainTime = $task->begin->addMinutes($task->time);
          }

        }

        return view('tasks.show')
            ->with('task', $task)
            ->with('gut', $gut)
            ->with('taskDelay', $taskDelay)
            ->with('pausedTask', $pausedTask)
            ->with('remainTime', $remainTime)
            ->with('logs', Log::where('task_id', $id)->orderBy('id', 'DESC')->get())
            ->with('messages', Message::where('task_id', $id)->get());
    }

    public function log(Task $task, $message)
    {
        $log = new Log();
        $log->task_id = $task->id;
        $log->user_id = Auth::user()->id;
        $log->message = $message;
        $log->save();
    }

    public function pause($id)
    {
        $task = Task::find($id);

        $taskPause = new TaskPause();
        $taskPause->task_id = $task->id;
        $taskPause->user_id = Auth::user()->id;
        $taskPause->message = Req::input('message');
        $taskPause->begin = new \DateTime('now');
        $taskPause->save();

        $this->log($task, 'Pausou a tarefa ' . $task->name);
    }

    public function unPause($id)
    {
        $pausedTask = TaskPause::find($id);
        $pausedTask->end = new \DateTime('now');
        $pausedTask->save();

        $this->log($pausedTask->task, 'Continuou a tarefa ' . $pausedTask->task->description);
    }

    public function finish($id)
    {
        $task = Task::findOrfail($id);

        $task->status_id = Task::STATUS_FINALIZADO;
        $task->end = new \DateTime();

        $task->save();

        $this->log($task, ' Finalizou a tarefa a tarefa ' . $task->name);

        //flash('A tarefa foi finalizada com sucesso.')->success()->important();

        return redirect()->back();
    }

    public static function getColorFromValue($value)
    {
          switch ($value) {
            case 2:
                return 'primary';
            case 3:
                return 'success';
            case 4:
                return 'warning';
            case 5:
                return 'danger';
            default:
                return 'default';
          }
    }

    public function startTask($id)
    {
        $task = Task::findOrfail($id);

        $task->status_id = Task::STATUS_EM_ANDAMENTO;
        $task->begin = new \DateTime();

        $task->save();

        return redirect()->back();
    }

    public static function taskDelayed($task)
    {
        $dateTime = new \DateTime('now');
        $start = $task->begin;

        if($task->status->id != 2) {
          return;
        }

        if(empty($start)) {
          return;
        }

        return $dateTime > $start ? 'class="danger" data-toggle="tooltip" data-placement="bottom" title="Tarefa Atrasada"' : '';
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::uuid($id);

        $time = 0;

         $hours = floor($task->time / 60);
         $minutes = ($task->time % 60);

         if ($hours < 10) {
            $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
         }

         return view('tasks.edit')
            ->with('task', $task)
            ->with('time', "{$hours}:{$minutes}");
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
        $data = $request->request->all();

        $task = Task::uuid($id);

        $task->description = $data['description'];
        $task->time = $data['time'];
        $task->time_type = $data['time_type'];
        $task->severity = $data['severity'];
        $task->urgency = $data['urgency'];
        $task->trend = $data['trend'];

        $task->sponsor_id = $data['sponsor_id'];
        $task->requester_id = $data['requester_id'];

        $task->save();

        $log = new Log();
        $log->task_id = $task->id;
        $log->user_id = Auth::user()->id;
        $log->message = 'Editou a tarefa ' . $task->name;
        $log->save();

        //flash('A tarefa foi editada com sucesso.')->success()->important();

        return redirect()->route('tasks.show', ['id' => $task->uuid]);
    }

    public function delay(Request $request, $id)
    {
      try {
        $data = $request->request->all();

        $task = Task::find($id);

        $taskDelay = new Delay();
        $taskDelay->user_id = Auth::user()->id;
        $taskDelay->message = $data['message'];
        $taskDelay->task_id = $id;
        $taskDelay->save();

        $log = new Log();
        $log->task_id = $task->id;
        $log->user_id = Auth::user()->id;
        $log->message = 'Adicionou o motivo do atraso com a tarefa ' .
        $task->description . ' motivo: ' . $data['message'];
        $log->save();

        return response()->json([
            'class' => 'Sucesso',
            'message' => 'O motivo foi enviado com sucesso.'
        ]);
      } catch(Exception $e) {
        return response()->json([
            'class' => 'Erro',
            'message' => $e->getMessage()
        ]);
      }
    }

    public static function toGraph()
    {
        $date = new \DateTime('now');
        $lastMonth = $date->modify('-1 month');
        $selectedDate = (string)$lastMonth->format('Y-m-d H:i:s');
        $itens = [];

        $tasks = Task::where('created_at', '>', $selectedDate)->get();

        $tasks = $tasks->toArray();

        $itensAtTime = 0;
        $itensDelayed = 0;

        foreach ($tasks as  $task) {

            if($task['status_id'] != Task::STATUS_FINALIZADO) {
                continue;
            }

            $dateTime = (new \DateTime($task['created_at']))->format('Y, m, d');

            if ($task['spent_time'] < $task['time']) {

                $itensAtTime++;

                $itens['atTime'][$dateTime] = $itensAtTime;

                continue;
            }

            $itensDelayed++;

            $itens['delay'][$dateTime] = $itensDelayed;
        }

        return json_encode($itens);
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

    public static function ociousTime($mapperID)
    {
        $mapper = Mapper::find($mapperID);

        $user = User::find($mapper->user->id);

        $week = 44;
        $days = 5;

        $time = ($week) * 60;

        $workTime = $mapper->tasks->sum('time');

        /*
        $workTime = $mapper->tasks->filter(function($task) {
            return $task->status->id == 2 || $task->status->id == 3;
        })->sum('time');
        */

        $rest = $time - $workTime;

        if(0 > $rest) {
          echo '<span class="label label-primary"><i class="fa fa-thumbs-up"></i> Sem tempo ocioso.</span>';
          return;
        }

        return HomeController::minutesToHour($rest);
    }

    public static function existsTaskByClient($client, $process)
    {
        $hasTasks = Task::where('owner_id', $client->id)->where('process_id', $process->id)->whereIn('status_id', [1,2])->get();

        return $hasTasks->isNotEmpty();
    }

    public static function existsTaskByProcess($process)
    {
        $hasTasks = Task::where('sub_process_id', $process->id)->get();

        return $hasTasks->isNotEmpty();
    }
}
