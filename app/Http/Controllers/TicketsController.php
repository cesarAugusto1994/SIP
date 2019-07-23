<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Ticket\Status\Log;
use Auth;
use App\User;
use Notification;
use Storage;
use File;
use App\Notifications\{NewTicket,FinishedTicket,ConcludedTicket};

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if($user->hasRole('user')) {

            $tickets =  $user->tickets();

            $opened = $user->tickets->filter(function($ticket, $key) {
              return $ticket->logs->last()->status_id == 1 || $ticket->logs->last()->status_id == 2 || $ticket->logs->last()->status_id == 3;
            })->count();

            $finished = $user->tickets->filter(function($ticket, $key) {
              return $ticket->logs->last()->status_id == 4;
            })->count();

            $canceled = $user->tickets->filter(function($ticket, $key) {
              return $ticket->logs->last()->status_id == 5;
            })->count();

            return view('tickets.index-user', compact('tickets', 'opened', 'finished', 'canceled'));
        }

        $tickets = Ticket::all();

        $opened = $tickets->filter(function($ticket, $key) {
          return $ticket->logs->last()->status_id == 1 || $ticket->logs->last()->status_id == 2 || $ticket->logs->last()->status_id == 3;
        })->count();

        $finished = $tickets->filter(function($ticket, $key) {
          return $ticket->logs->last()->status_id == 4;
        })->count();

        $canceled = $tickets->filter(function($ticket, $key) {
          return $ticket->logs->last()->status_id == 5;
        })->count();

        $total = $tickets->count() > 0 ? $tickets->count() : 1;
        $low =  $tickets->where('priority', 'Baixa')->count();
        $normal =  $tickets->where('priority', 'Normal')->count();
        $high =  $tickets->where('priority', 'Alta')->count();
        $highest =  $tickets->where('priority', 'Altissima')->count();

        $low = number_format(($low/$total) * 100, 2);
        $normal = number_format(($normal/$total) * 100, 2);
        $high = number_format(($high/$total) * 100, 2);
        $highest = number_format(($highest/$total) * 100, 2);

        if($request->filled('status')) {
            $status = $request->get('status');
            $tickets = $tickets->where('status_id', $status);
        }

        if($request->filled('priority')) {
            $priority = $request->get('priority');
            $tickets = $tickets->where('priority', $priority);
        }

        if($request->filled('date')) {
            $date = $request->get('date');
            $tickets = $tickets->filter(function($ticket, $key) use ($date) {

              $datePeriod = now()->subDays(0);

              if($date == 'hoje') {
                  return $ticket->created_at > now()->setTime(0,0,0) &&
                  $ticket->created_at < now()->setTime(23,59,59);
              } elseif($date == 'ontem') {
                  return $ticket->created_at > now()->subDays(1)->setTime(0,0,0) &&
                  $ticket->created_at < now()->subDays(1)->setTime(23,59,59);
              } elseif($date == 'semana') {
                  return $ticket->created_at > now()->subDays(7)->setTime(0,0,0) &&
                  $ticket->created_at < now()->setTime(23,59,59);
              } elseif($date == 'mes') {
                  return $ticket->created_at > now()->subDays(30)->setTime(0,0,0) &&
                  $ticket->created_at < now()->setTime(23,59,59);
              } elseif($date == 'ano') {
                  return $ticket->created_at > now()->subDays(365)->setTime(0,0,0) &&
                  $ticket->created_at < now()->setTime(23,59,59);
              } elseif($date == 'recente') {
                  return $ticket->created_at > now()->subHours(2)->setTime(0,0,0) &&
                  $ticket->created_at < now()->setTime(23,59,59);
              }

              return $ticket->created_at == $datePeriod;

            });
        }

        if($request->filled('user')) {
            $user = $request->get('user');
            $tickets = $tickets->where('user.id', $user);
        }

        if($request->filled('type')) {
            $type = $request->get('type');
            $tickets = $tickets->where('type.id', $type);
        }

        return view('tickets.index', compact('tickets', 'opened', 'finished', 'canceled', 'total', 'low', 'normal', 'high', 'highest'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create');
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
        $data['status_id'] = 1;

        $ticket = Ticket::create($data);

        $alreadyExists = Log::where('ticket_id', $ticket->id)->where('status_id', 1)->get();

        if($alreadyExists->isNotEmpty()) {
            return back();
        }

        Log::create([
          'status_id' => 1,
          'ticket_id' => $ticket->id,
          'description' => 'Chamado aberto por ' . $request->user()->person->name
        ]);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo chamado adicionado com sucesso.'
        ]);

        $usersCollection = collect();

        if($ticket->type) {
          $departments = $ticket->type->departments;
          if($departments->isNotEmpty()) {
            foreach ($departments as $key => $department) {
                $department = $department->department;
                foreach ($department->people as $key => $person) {
                    $usersCollection->push($person->user);
                }
            }
          }
        }

        Notification::send($usersCollection, new NewTicket($ticket));

        return redirect()->route('tickets.index');
    }

    public function startTicket($id, Request $request)
    {
        $user = $request->user();

        $data['assigned_to'] = $user->id;

        $ticket = Ticket::uuid($id);

        $alreadyExists = Log::where('ticket_id', $ticket->id)->where('status_id', 2)->get();

        if($alreadyExists->isNotEmpty()) {
            return back();
        }

        Log::create([
          'status_id' => 2,
          'ticket_id' => $ticket->id,
          'description' => 'Chamado atribuído à ' . $request->user()->person->name
        ]);

        $data['status_id'] = 2;

        $ticket->update($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'O chamado está em andamento.'
        ]);

        return redirect()->route('tickets.show', $ticket->uuid);
    }

    public function concludeTicket($id, Request $request)
    {
        $user = $request->user();

        $data['solved_at'] = now();

        $ticket = Ticket::uuid($id);

        $alreadyExists = Log::where('ticket_id', $ticket->id)->where('status_id', 3)->get();

        if($alreadyExists->isNotEmpty()) {
            return back();
        }

        Log::create([
          'status_id' => 3,
          'ticket_id' => $ticket->id,
          'description' => 'Chamado concluído por ' . $request->user()->person->name
        ]);

        $data['status_id'] = 3;

        $ticket->update($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'O chamado foi conclído pelo responsávelcom sucesso.'
        ]);

        Notification::send($ticket->user, new ConcludedTicket($ticket));

        return redirect()->route('tickets.show', $ticket->uuid);
    }

    public function finishTicket($id, Request $request)
    {
        $user = $request->user();

        $data['solved_at'] = now();

        $ticket = Ticket::uuid($id);

        $alreadyExists = Log::where('ticket_id', $ticket->id)->where('status_id', 4)->get();

        if($alreadyExists->isNotEmpty()) {
            return back();
        }

        Log::create([
          'status_id' => 4,
          'ticket_id' => $ticket->id,
          'description' => 'Chamado finalizado por ' . $request->user()->person->name
        ]);

        $data['status_id'] = 4;

        $ticket->update($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'O chamado foi finalizado com sucesso.'
        ]);

        $users = User::whereIn('id', [$ticket->user->id, $ticket->assigned_to])->get();

        Notification::send($users, new FinishedTicket($ticket));

        return redirect()->route('tickets.show', $ticket->uuid);
    }

    public function cancelTicket($id, Request $request)
    {
        $user = $request->user();

        $ticket = Ticket::uuid($id);

        $alreadyExists = Log::where('ticket_id', $ticket->id)->where('status_id', 5)->get();

        if($alreadyExists->isNotEmpty()) {
            return back();
        }

        Log::create([
          'status_id' => 5,
          'ticket_id' => $ticket->id,
          'description' => 'Chamado cancelado por ' . $request->user()->person->name
        ]);

        $data['status_id'] = 4;
        $ticket->update($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Chamado cancelado com sucesso.'
        ]);

        return redirect()->route('tickets.show', $ticket->uuid);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::uuid($id);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::uuid($id);
        return view('tickets.edit', compact('ticket'));
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

        $ticket = Ticket::uuid($id);
        $ticket->update($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Chamado atualizado com sucesso.'
        ]);

        return redirect()->route('tickets.index');
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
}
