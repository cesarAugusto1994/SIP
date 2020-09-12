<?php

use Illuminate\Database\Seeder;
use App\Models\Ticket\Status;

class TicketStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = ['Aberto', 'Em Andamento', 'Concluído', 'Finalizado', 'Cancelado', 'Sem resposta'];

        foreach ($itens as $key => $item) {
            Status::create(['name' => $item]);
        }
    }
}
