<?php

use Illuminate\Database\Seeder;
use App\Models\ServiceOrder\ServiceOrder\Item\Status;

class ServiceOrderItemStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = ['Pendente',
                  'Em Andamento',
                  'Finalizada',
                  'Não Executada',
                  'Cancelada'];

        foreach($items as $item) {
            Status::create(['name' => $item]);
        }
    }
}
