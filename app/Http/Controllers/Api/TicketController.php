<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::take(3)->get();

        return response()->json([
          'status' => 200,
          'data' => $tickets->map(function($ticket) {
              return [
                  'id' => $ticket->uuid,
                  'description' => $ticket->description,
                  'status' => $ticket->status->name,
                  'type' => $ticket->type->name,
                  'user' => $ticket->user->person->name,
                  'created' => $ticket->created_at,
              ];
          })
        ]);
    }
}
