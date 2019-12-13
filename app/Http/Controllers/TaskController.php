<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\{Ticket, Task, Department, Mapper};
use App\Models\Ticket\Status\Log as TicketLog;
use App\Models\Task\{Message, Status, Log, Delay, Pause, Archive as FileUpload};
use Illuminate\Http\Request;
use Request as Req;
use Notification;
use Auth;
use Storage;
use DateTime;
use DateInterval;
use DatePeriod;
use App\Helpers\Helper;
use App\Notifications\{NewTicket,FinishedTicket,ConcludedTicket};

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::orderByDesc('id');

        $user = $request->user();

        if(!$user->isAdmin()) {
            $tasks->where('sponsor_id', $user->id)
            ->orWhere('user_id', $user->id);
        }

        if($request->filled('status')) {
            $status = $request->get('status');
            $tasks->where('status_id', $status);
        }

        if($request->filled('code')) {
            $search = $request->get('code');
            $tasks->where('id', $search)
            ->orWhere('name', "%$search%")
            ->orWhere('description', "%$search%");
        }

        if(!$request->has('find')) {
            $tasks->whereIn('status_id', [1,2]);
        }

        if($request->filled('severity')) {
            $priority = $request->get('severity');
            $tasks->where('severity', $priority);
        }

        if($request->filled('urgency')) {
            $priority = $request->get('urgency');
            $tasks->where('urgency', $priority);
        }

        if($request->filled('trend')) {
            $priority = $request->get('trend');
            $tasks->where('trend', $priority);
        }

        if($request->filled('start')) {
            $start = \DateTime::createFromFormat('d/m/Y', $request->get('start'));
            $tasks->where('created_at', '>=', $start->format('Y-m-d') . ' 00:00:00');
        }

        if($request->filled('end')) {
            $end = \DateTime::createFromFormat('d/m/Y', $request->get('end'));
            $tasks->where('created_at', '<=', $end->format('Y-m-d') . ' 23:59:59');
        }

        if($request->filled('user')) {
            $user = $request->get('user');
            $tasks = $tasks->where('user_id', $user);
        }

        $quantity = $tasks->count();

        $tasks = $tasks->paginate();

        return view('tasks.index', compact('quantity', 'tasks'));
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
          'name' => 'required',
          'time' => 'required',
          'time_type' => 'required',
          'severity' => 'required',
          'urgency' => 'required',
          'trend' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $start = $end = null;

        if($request->filled('start')) {
            $start = DateTime::createFromFormat('d/m/Y', $data['start']);
        }

        if($request->filled('end')) {
            $end = DateTime::createFromFormat('d/m/Y', $data['end']);
            $end->setTime(23,59,59);
        }

        $timeType = $data['time_type'];
        $time = $data['time'];

        $data['status_id'] = Task::STATUS_PENDENTE;
        $data['user_id'] = Auth::user()->id;

        $interval = new DateInterval('P1D');

        $weekDays = ['Segunda','Terca','Quarta','Quinta','Sexta'];

        if(in_array($data['frequency'], $weekDays)) {

          if(!$start) {
            return back()->withErrors(['frequency' => 'A data de Início deve ser informada para a frequencia selecionada.'])->withInput();
          }

          $dayName = Helper::convertToEnglish($data['frequency']);

          $start->modify('next ' . $dayName);

          $interval = DateInterval::createFromDateString('7 day');

        } elseif($data['frequency'] == 'Diariamente') {

          if(!$start) {
            return back()->withErrors(['start' => 'A data de Início deve ser informada para a frequencia selecionada.'])->withInput();
          }

          if($timeType == 'day' && $time > 1) {
              return back()->withErrors(['time' => 'Tempo inválido para a frequencia selecionada, deve ser menor ou igual a 1 dia.'])->withInput();
          }

          if($timeType == 'hour' && $time > 24) {
              return back()->withErrors(['time' => 'Tempo inválido para a frequencia selecionada, deve ser menor ou igual a 24 horas.'])->withInput();
          }

          if($timeType == 'minute' && $time > 1440) {
              return back()->withErrors(['time' => 'Tempo inválido para a frequencia selecionada, deve ser menor ou igual a 1440 minutos.'])->withInput();
          }

          $interval = DateInterval::createFromDateString('1 day');

        } elseif($data['frequency'] == 'Semanalmente') {

          if(!$start) {
            return back()->withErrors(['frequency' => 'A data de Início deve ser informada para a frequencia selecionada.'])->withInput();
          }

          if($timeType == 'day' && $time > 7) {
              return back()->withErrors(['time' => 'Tempo inválido para a frequencia selecionada, deve ser menor ou igual a 7 dias.'])->withInput();
          }

          if($timeType == 'hour' && $time > 168) {
              return back()->withErrors(['time' => 'Tempo inválido para a frequencia selecionada, deve ser menor ou igual a 7 dias.'])->withInput();
          }

          if($timeType == 'minute' && $time > 10080) {
              return back()->withErrors(['time' => 'Tempo inválido para a frequencia selecionada, deve ser menor ou igual a 7 dias.'])->withInput();
          }

          $interval = DateInterval::createFromDateString('1 week');

        } elseif($data['frequency'] == 'Mensalmente') {

          if(!$start) {
            return back()->withErrors(['frequency' => 'A data de Início deve ser informada para a frequencia selecionada.'])->withInput();
          }

          if($timeType == 'day' && $time > 31) {
              return back()->withErrors(['time' => 'Tempo inválido para a frequencia selecionada, deve ser menor ou igual a 31 dias.'])->withInput();
          }

          if($timeType == 'hour' && $time > 744) {
              return back()->withErrors(['time' => 'Tempo inválido para a frequencia selecionada, deve ser menor ou igual a 31 dias.'])->withInput();
          }

          if($timeType == 'minute' && $time > 44640) {
              return back()->withErrors(['time' => 'Tempo inválido para a frequencia selecionada, deve ser menor ou igual a 31 dias.'])->withInput();
          }

          $interval = DateInterval::createFromDateString('1 month');

        } else {

          $data['start'] = $start;

          if($start) {
            $endTask = $start;
            $data['end'] = $endTask->modify('+' . $data['time'] . ' ' . $data['time_type']);
          }

          $task = Task::create($data);

          Log::create([
            'task_id' => $task->id,
            'user_id' => Auth::user()->id,
            'message' => 'Criou a tarefa ' . $task->name,
            'status_id' => Task::STATUS_PENDENTE
          ]);

          return redirect()->route('tasks.index');

        }

        if(!$end) {
          //TODO
        }

        $period = new DatePeriod($start, $interval, $end);

        $invalidaDates = ['Saturday', 'Sunday'];

        foreach ($period as $dt) {

            if(in_array($dt->format('l'), $invalidaDates)) {
              continue;
            }

            $data['start'] = $start;
            $endTask = $start;
            $data['end'] = $endTask->modify('+' . $data['time'] . ' ' . $data['time_type']);

            $data['created_at'] = $dt;
            $data['start'] = $dt;
            $task = Task::create($data);

            Log::create([
              'task_id' => $task->id,
              'user_id' => Auth::user()->id,
              'message' => 'Criou a tarefa ' . $task->name,
              'status_id' => Task::STATUS_PENDENTE
            ]);
        }

        return redirect()->route('tasks.index');
    }

    public function upload(Request $request, $id)
    {
        $task = Task::uuid($id);

        if ($request->hasFile('files')) {

            foreach ($request->file('files') as $key => $file) {

              $name = $file->getClientOriginalName();
              $path = $file->store('tasks');

              FileUpload::create([
                  'task_id' => $task->id,
                  'filename' => $name,
                  'path' => $path,
                  'size' => $file->getSize(),
                  'user_id' => $request->user()->id,
              ]);

            }

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

    public function fileRemove($id)
    {
        try {
          $file = FileUpload::uuid($id);

          if(Storage::exists($file->path)) {
              Storage::delete($file->path);
          }

          $file->delete();

          return response()->json([
            'success' => true,
            'message' => 'O Arquivo foi removido com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado'
          ]);
        }
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
                $task->start = now();
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
                $horaInicio = new \DateTime($task->start);
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

                if($task->ticket) {

                  $ticket = $task->ticket;

                  TicketLog::create([
                    'status_id' => 3,
                    'ticket_id' => $ticket->id,
                    'description' => 'Chamado concluído por ' . auth()->user()->person->name
                  ]);

                  $data['status_id'] = 3;

                  $ticket->update($data);

                  notify()->flash('Sucesso!', 'success', [
                    'text' => 'Sua tarefa foi finalizada e o chamado foi concluído pelo responsável.'
                  ]);

                  Notification::send($ticket->user, new ConcludedTicket($ticket));

                }

                return redirect()->route('tasks.show', ['id' => $task->uuid]);
            }

            if (Req::get('cancel')) {
                $task->status_id = Task::STATUS_CANCELADO;
                $task->start = $task->end = new \DateTime('now');
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
                    'severity' => $task->severity,
                    'urgency' => $task->urgency,
                    'trend' => $task->trend,
                    'status_id' => Task::STATUS_PENDENTE,
                    'sponsor_id' => $user,
                    'requester_id' => $user,
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

        if($task->start) {

          if($task->time_type == 'day') {
              $remainTime = $task->start->addDays($task->time);
          } elseif ($task->time_type == 'hour') {
              $remainTime = $task->start->addHours($task->time);
          } elseif ($task->time_type == 'minute') {
              $remainTime = $task->start->addMinutes($task->time);
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
        $log->status_id = $task->status_id;
        $log->user_id = Auth::user()->id;
        $log->message = $message;
        $log->save();
    }

    public function status($id, Request $request)
    {
        $task = Task::uuid($id);

        $status = Status::find($request->get('status'));

        $motive = "";

        if($request->has('message')) {
            $motive = $request->get('message');
        }

        switch ($status->id) {
          case 1:
            $message = "Adicionou uma nova tarefa";
            break;
          case 2:
            $message = "Atualizou o status da tarefa para Em Andamento";
            break;
          case 3:
            $message = "Finalizou a tarefa";
            break;
          case 4:
            $message = "Cancelou a tarefa";
            break;
          case 5:
            $message = "Pausou a tarefa, motivo: " . $motive;
            break;
        }

        Log::create([
          'status_id' => $status->id,
          'task_id' => $task->id,
          'user_id' => Auth::user()->id,
          'message' => $message
        ]);

        $data['status_id'] = $status->id;

        $task->update($data);

        return response()->json([
          'success' => true,
          'message' => 'Status da tarefa atualizado com sucesso.'
        ]);
    }

    public function duplicate($id, Request $request)
    {
        $task = Task::uuid($id);

        $user = Auth::user()->isAdmin() ? $task->user_id : Auth::user()->id;

        $data = [
            'name' => $task->name,
            'description' => $task->description,
            'user_id' => $user,
            'frequency' => $task->frequency,
            'time' => $task->time,
            'severity' => $task->severity,
            'urgency' => $task->urgency,
            'trend' => $task->trend,
            'status_id' => Task::STATUS_PENDENTE,
            'sponsor_id' => $user,
            'requester_id' => $user,
        ];

        $newTask = Task::create($data);

        $this->log($task, 'Duplicou a tarefa ' . $task->name);
        $this->log($newTask, 'Criou a tarefa ' . $newTask->name);

        return response()->json([
          'success' => true,
          'message' => 'Uma nova tarefa foi criada.',
          'route' => route('tasks.show', ['id' => $newTask->uuid])
        ]);
    }

    public function pause($id, Request $request)
    {
        $task = Task::uuid($id);

        $taskPause = new TaskPause();
        $taskPause->task_id = $task->id;
        $taskPause->user_id = Auth::user()->id;
        $taskPause->message = Req::input('message');
        $taskPause->start = new \DateTime('now');
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
        $task->start = new \DateTime();

        $task->save();

        return redirect()->back();
    }

    public static function taskDelayed($task)
    {
        $dateTime = new \DateTime('now');
        $start = $task->start;

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
    public function edit($id, Request $request)
    {
        $task = Task::uuid($id);

        $time = 0;

         $hours = floor($task->time / 60);
         $minutes = ($task->time % 60);

         if ($hours < 10) {
            $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
         }

         return view('tasks.edit', compact('task'))
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

        $start = $end = null;

        if($request->filled('start')) {
            $start = DateTime::createFromFormat('d/m/Y', $data['start']);
        }

        if($request->filled('end')) {
            $end = DateTime::createFromFormat('d/m/Y', $data['end']);
            $end->setTime(23,59,59);
        }

        $data['start'] = $start;
        $data['end'] = $end;

        $task->update($data);

        $log = new Log();
        $log->task_id = $task->id;
        $log->user_id = Auth::user()->id;
        $log->message = 'Editou a tarefa ' . $task->name;
        $log->status_id = $task->status_id;
        $log->save();

        return redirect()->route('tasks.show', ['id' => $task->uuid]);
    }

    public function updateConclusioPercente($id, Request $request)
    {
      try {

        $task = Task::uuid($id);

        $task->update([
          'percent_conclusion' => $request->get('value')
        ]);

        $log = new Log();
        $log->task_id = $task->id;
        $log->user_id = Auth::user()->id;
        $log->message = 'Atualizou o Progresso da tarefa ' . $task->name . ' para ' . $task->percent_conclusion .'%';
        $log->status_id = $task->status_id;
        $log->save();

        return response()->json([
          'success' => true,
          'message' => 'Progresso atualizado com sucesso.',
        ]);

      } catch(\Exception $e) {
        return response()->json([
          'success' => false,
          'message' => 'Ocorreu um erro inesperado',
        ]);
      }
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
