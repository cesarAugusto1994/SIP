<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fleet\Vehicle;
use App\Models\Fleet\Schedule;
use App\Models\Fleet\Schedule\Guest;
use App\User;
use DateTime;

class VahicleScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::where('status_id', 1)->where('active', true)->get();
        return view('fleet.schedule', compact('vehicles'));
    }

    public function schedule(Request $request)
    {
        $user = auth()->user();

        $cardCollor = "#1ab394";
        $editable = false;

        $data = [];

        foreach ($user->vehicleSchedules as $key => $schedule) {
          switch($schedule->vehicle_id) {
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
              'title' => $schedule->vehicle->name . ' Agendado para: ' . $schedule->user->person->name,
              'description' => $schedule->description,
              'start' => $schedule->start ? $schedule->start->format('Y-m-d H:i') : null,
              'end' => $schedule->end ? $schedule->end->format('Y-m-d H:i') : null,
              'color' => $cardCollor,
              'editable' => $editable,
              'route' => route('vehicle-schedule.show', $schedule->uuid),
              'update' => route('vehicle-schedule.update', $schedule->uuid)
          ];
        }

        foreach ($user->vehicleScheduleGuest as $key => $guest) {
            foreach ($guest->vehicleSchedules as $keya => $schedule) {

              switch($schedule->vehicle_id) {
                case 1:
                  $cardCollor = "#23c6c8";
                break;
                case 2:
                  $cardCollor = "#f8ac59";
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
                  'title' => 'Compartilhado por ' . $schedule->user->person->name . ' - ' . $schedule->type->name . ': ' . $schedule->title,
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

        $data['user_id'] = $user->id;

        $start = DateTime::createFromFormat('d/m/Y H:i', $data['start']);
        $end = DateTime::createFromFormat('d/m/Y H:i', $data['end']);

        if($end->format('H') == "00") {
          $end->modify('-1 second');
        }

        $has = Schedule::where('vehicle_id', $data['vehicle_id'])
        ->whereBetween('start', [$start, $end])
        ->orWhereBetween('end', [$start, $end])
        ->get();

        if($has->isNotEmpty()) {

          notify()->flash('Erro', 'success', [
            'text' => 'Este Veículo já Agendado para esta data.'
          ]);

          return back();
        }

        $data['start'] = $start;
        $data['end'] = $end;
        $data['status_id'] = 1;

        $schedule = Schedule::create($data);

        if($request->has('guests')) {

            foreach ($request->get('guests') as $key => $guest) {
                Guest::create([
                  'schedule_id' => $schedule->id,
                  'user_id' => $guest
                ]);
            }

            $users = User::whereIn('id', $request->get('guests'))->get();

            if($request->has('send_notification_mail')) {
                //Notification::send($users, new ScheduleInvite($schedule));
            }

            foreach ($users as $key => $user) {
                //broadcast(new Notifications($user, 'Você foi marcado em um compromisso.'))->toOthers();
            }

        }

        notify()->flash('Sucesso', 'success', [
          'text' => 'Veículo Agendado com sucesso.'
        ]);

        return redirect()->route('vehicle-schedule.index');
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
        return view('fleet.show', compact('schedule'));
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
        //
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

          $route = route('vehicle-schedule.index');

          $schedule->delete();

          return response()->json([
            'success' => true,
            'message' => 'Agendamento de Veículo removido com sucesso.',
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
