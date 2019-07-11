<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Ticket\Status\Log;
use Auth;
use App\User;
use Notification;
use App\Notifications\{NewTicket,FinishedTicket,ConcludedTicket};

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
/*
            $opened = $user->tickets()->whereHas('logs', function($query) {
              $query->where('status_id', 1);
            })->count();

            $finished = $user->tickets()->whereHas('logs', function($query) {
              $query->where('status_id', 4);
            })->count();

            $canceled = $user->tickets()->whereHas('logs', function($query) {
              $query->where('status_id', 5);
            })->count();
*/
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

        return view('tickets.index', compact('tickets', 'opened', 'finished', 'canceled'));
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

        Notification::send(User::where('id', 2)->get(), new NewTicket($ticket));

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
        'description' => 'Chamado por ' . $request->user()->person->name
      ]);

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
        //
    }
}
