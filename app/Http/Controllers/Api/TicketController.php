<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::orderByDesc('id');

        if($request->has('q')) {
            $search = $request->get('q');
            $tickets->where('id', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%");
        }

        $tickets = $tickets->paginate(10);

        $result = [];

        foreach ($tickets as $key => $ticket) {
            $result[] = [
                'id' => $ticket->uuid,
                'code' => str_pad($ticket->id, 6, "0", STR_PAD_LEFT),
                'description' => html_entity_decode(strip_tags(substr($ticket->description, 0, 800))) .
                    PHP_EOL . PHP_EOL . 'Solicitante: ' . $ticket->user->person->name .
                    PHP_EOL . 'Situação: ' . $ticket->status->name,
                'status' => $ticket->status->name,
                'type' => $ticket->type->name,
                'user' => $ticket->user->person->name,
                'created' => $ticket->created_at,
            ];
        }

        return response()->json($result);
    }
}
