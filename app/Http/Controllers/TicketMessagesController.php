<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\Notifications;
use App\Models\Ticket\Message;
use App\Models\Ticket;
use Auth;

class TicketMessagesController extends Controller
{
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

        $ticket = Ticket::uuid($data['id']);

        $message = new Message();
        $message->message = $data['message'];
        $message->user_id = Auth::user()->id;
        $message->ticket_id = $ticket->id;

        $message->save();

        $msg = $user->person->name . ' adicionou um novo comentário no chamado #'. str_pad($ticket->id, 6, "0", STR_PAD_LEFT);

        if($ticket->user->id == $user->id) {
          if($ticket->responsible) {
            broadcast(new Notifications($ticket->responsible, $msg))->toOthers();
          }
        } else {
            broadcast(new Notifications($ticket->user, $msg))->toOthers();
        }

        return redirect()->route('tickets.show', $ticket->uuid);
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

            $message = Message::uuid($id);
            $message->delete();

            return response()->json([
              'success' => true,
              'message' => 'Mensagem apagada com sucesso.'
            ]);

        } catch(\Exception $e) {

            return response()->json([
              'success' => false,
              'message' => 'Ocorreu um erro ao remover a mensagem'
            ]);

        }
    }
}
