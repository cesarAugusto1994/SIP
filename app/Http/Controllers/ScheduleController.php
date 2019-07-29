<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Schedule\Guest;
use App\Notifications\ScheduleInvite;
use App\Models\Task;
use App\Models\Task\Log;
use App\Helpers\Helper;
use App\Events\Notifications;
use Notification;
use DateTime;
use App\User;
use Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        return view('schedules.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $user = $request->user();

        $start = DateTime::createFromFormat('d/m/Y H:i', $data['start']);
        $end = DateTime::createFromFormat('d/m/Y H:i', $data['end']);

        $dateDiff = $end->diff($start);

        $timeTask = $dateDiff->i;

        if($dateDiff->d > 0) {
            $timeTask = $dateDiff->d;
        } elseif ($dateDiff->h > 0) {
            $timeTask = $dateDiff->h;

            if($dateDiff->h > 0) {
              $timeTask++;
            }

        }

        $schedule = Schedule::create([
          'title' => $data['title'],
          'description' => $data['description'],
          'localization' => $data['localization'],
          'type_id' => $data['event_type'],
          'user_id' => $user->id,
          'start' => $start,
          'end' => $end,
        ]);

        if($request->has('do_task')) {

          $data = [
              'name' => $schedule->title,
              'description' => $schedule->description,
              'user_id' => $user->id,
              'time' => $timeTask,
              'severity' => 1,
              'urgency' => 1,
              'trend' => 1,
              'status_id' => Task::STATUS_PENDENTE,
              'sponsor_id' => $user->id,
              'schedule_id' => $schedule->id,
          ];

          $task = Task::create($data);

          Log::create([
            'task_id' => $task->id,
            'status_id' => $task->status_id,
            'user_id' => $user->id,
            'message' => 'Tarefa Criada através da de agendamento',
          ]);

        }

        if($request->has('guests')) {

          if(in_array('todos', $request->get('guests')) !== false) {

            $users = User::whereNotIn('id', [auth()->user()->id, 1])->get();

            foreach ($users as $key => $user) {

                Guest::create([
                  'schedule_id' => $schedule->id,
                  'user_id' => $user->id
                ]);

                broadcast(new Notifications($user, 'Você foi marcado em um compromisso.'))->toOthers();

            }

            if($request->has('send_notification_mail')) {
                Notification::send($users, new ScheduleInvite($schedule));
            }

          } else {

            foreach ($request->get('guests') as $key => $guest) {
                Guest::create([
                  'schedule_id' => $schedule->id,
                  'user_id' => $guest
                ]);
            }

            $users = User::whereIn('id', $request->get('guests'))->get();

            if($request->has('send_notification_mail')) {
                Notification::send($users, new ScheduleInvite($schedule));
            }

            foreach ($users as $key => $user) {
                broadcast(new Notifications($user, 'Você foi marcado em um compromisso.'))->toOthers();
            }

          }

        }

        notify()->flash('Sucesso', 'success', [
          'text' => 'Novo compromissio adicionado.'
        ]);

        return redirect()->route('schedules.index');
    }

    public function schedule(Request $request)
    {
        $user = auth()->user();

        $cardCollor = "#1ab394";
        $editable = false;

        $data = [];

        foreach ($user->schedules as $key => $schedule) {
          switch($schedule->type_id) {
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
              'id' => $schedule->id,
              'uuid' => $schedule->uuid,
              'type_id' => $schedule->type_id,
              'title' => $schedule->title,
              'description' => $schedule->description,
              'start' => $schedule->start ? $schedule->start->format('Y-m-d H:i') : null,
              'end' => $schedule->end ? $schedule->end->format('Y-m-d H:i') : null,
              'color' => $cardCollor,
              'editable' => $editable,
              'route' => route('schedules.show', $schedule->uuid),
              'update' => route('schedules.update', $schedule->uuid)
          ];
        }

        foreach ($user->guest as $key => $guest) {
            foreach ($guest->schedules as $keya => $schedule) {

              switch($schedule->type_id) {
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
                  'id' => $schedule->id,
                  'uuid' => $schedule->uuid,
                  'type_id' => $schedule->type_id,
                  'title' => $schedule->title,
                  'description' => $schedule->description,
                  'start' => $schedule->start ? $schedule->start->format('Y-m-d H:i') : null,
                  'end' => $schedule->end ? $schedule->end->format('Y-m-d H:i') : null,
                  'color' => $cardCollor,
                  'editable' => false,
                  'route' => route('schedules.show', $schedule->uuid),
                  'update' => route('schedules.update', $schedule->uuid)
              ];
            }
        }

        return json_encode($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schedule = Schedule::uuid($id);
        return view('schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = Schedule::uuid($id);
        return view('schedules.edit', compact('schedule'));
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

        $schedule = Schedule::uuid($id);

        $start = DateTime::createFromFormat('d/m/Y H:i', $data['start']);
        $end = DateTime::createFromFormat('d/m/Y H:i', $data['end']);

        $data['start'] = $start;
        $data['end'] = $end;

        $schedule->update($data);

        notify()->flash('Sucesso', 'success', [
          'text' => 'Compromissio atualizado com sucesso.'
        ]);

        if($request->has('updateByForm')) {
           return redirect()->route('schedules.show', $schedule->uuid);
        }

        return response()->json([
          'success' => true,
          'message' => 'Compromisso atualizado com sucesso.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

          $schedule = Schedule::uuid($id);

          $schedule->guests()->delete();

          $route = route('schedules.index');

          $schedule->delete();

          return response()->json([
            'success' => true,
            'message' => 'Compromisso removido com sucesso.',
            'route' => $route
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'route' => route('schedules.index')
          ]);
        }
    }
}
