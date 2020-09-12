<?php

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\Ticket\Status\Log;
use App\User;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $key => $user) {
          $ticket = Ticket::create([
            'user_id' => $user->id,
            'status_id' => 1,
            'type_id' => 1,
            'description' => 'Tarefa Teste',
          ]);

          Log::create([
            'status_id' => 1,
            'ticket_id' => $ticket->id,
            'description' => 'Chamado aberto por ' . $user->person->name
          ]);
        }
    }
}
