<?php

use Illuminate\Database\Seeder;
use App\Models\Task\Status;

class TaskStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = ['Pendente', 'Em Andamento', 'Finalizado', 'Cancelado'];

        foreach ($itens as $key => $item) {
            Status::create([
              'name' => $item
            ]);
        }
    }
}
