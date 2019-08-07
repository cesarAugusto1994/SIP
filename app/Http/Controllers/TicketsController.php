<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Ticket, Task};
use App\Models\Ticket\Status\Log;
use Auth;
use App\User;
use Notification;
use Storage;
use File;
use App\Notifications\{NewTicket,FinishedTicket,ConcludedTicket};
use App\Events\Notifications;
use App\Jobs\Ticket as TicketJob;

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

        if(!$user->isAdmin()) {

            $tickets = $user->tickets()->get();
            $ticketTypeDepts = $user->person->department->ticketTypesDepartments;

            foreach ($ticketTypeDepts as $key => $ticketTypeDept) {
                foreach ($ticketTypeDept->type->tickets as $key => $ticket) {
                  if(!$tickets->contains($ticket)) {
                      $tickets->push($ticket);
                  }
                }
            }

        } else {
            $tickets = Ticket::all();
        }

        $opened = $tickets->whereIn('status_id', [1,2,3])->count();
        $finished = $tickets->whereIn('status_id', [4])->count();
        $canceled = $tickets->whereIn('status_id', [5])->count();

        $total = $tickets->count();
        $low =  $tickets->where('priority', 'Baixa')->count();
        $normal =  $tickets->where('priority', 'Normal')->count();
        $high =  $tickets->where('priority', 'Alta')->count();
        $highest =  $tickets->where('priority', 'Altíssima')->count();

        $totalTickets = $total > 0 ? $total : 1;

        $low = number_format(($low/$totalTickets) * 100, 2);
        $normal = number_format(($normal/$totalTickets) * 100, 2);
        $high = number_format(($high/$totalTickets) * 100, 2);
        $highest = number_format(($highest/$totalTickets) * 100, 2);

        if($request->filled('status')) {
            $status = $request->get('status');
            $tickets = $tickets->where('status_id', $status);
        }

        if(!$request->has('status')) {
            //$tickets = $tickets->whereIn('status_id', [1,2]);
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

        TicketJob::dispatch($ticket, $usersCollection)->delay(now()->addMinutes(2));;

        //Notification::send($usersCollection, new NewTicket($ticket));

        foreach ($usersCollection as $key => $userA) {
            broadcast(new Notifications($userA, 'Novo Chamado aberto por ' . $user->person->name))->toOthers();
        }

        return redirect()->route('tickets.index');
    }

    public function startTicket($id, Request $request)
    {
        $data = $request->request->all();

        $user = $request->user();

        $ticket = Ticket::uuid($id);
/*
        $task = Task::create([
          'ticket_id' => $ticket->id,
          'name' => $ticket->type->category->name,
          'description' => $ticket->type->name . ': ' . $ticket->description,
          'user_id' => $user->id,
          'status_id' => 1,
          'priority' => $data['priority'],
          'requester_id' => $ticket->user_id,
          'sponsor_id' => $user->id,
        ]);

        $alreadyExists = Log::where('ticket_id', $ticket->id)->where('status_id', 2)->get();

        if($alreadyExists->isNotEmpty()) {
            return back();
        }

        Log::create([
          'status_id' => 2,
          'ticket_id' => $ticket->id,
          'description' => 'Chamado atribuído à ' . $request->user()->person->name
        ]);
*/
        $data['status_id'] = 2;
        $data['assigned_to'] = $user->id;

        $ticket->update($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'O chamado está em andamento.'
        ]);

        //return redirect()->route('tasks.edit', $task->uuid)->with('ticket', $ticket->uuid);

        //return view('tasks.edit', compact('task', 'ticket'));

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
          'text' => 'O chamado foi concluído pelo responsável.'
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

        $data['status_id'] = 5;
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
