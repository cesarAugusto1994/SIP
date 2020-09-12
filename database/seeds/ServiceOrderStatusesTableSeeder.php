<?php

use Illuminate\Database\Seeder;
use App\Models\ServiceOrder\ServiceOrder\Status;

class ServiceOrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = ['Aberta',
                  'Em Elaboração',
                  'Proposta Enviada ao Cliente',
                  'Aguardando Aprovação do Cliente',
                  'Negada',
                  'Aprovada',
                  'Autorizada',
                  'Cancelada',
                  'Finalizada'];

        foreach($items as $item) {
            Status::create(['name' => $item]);
        }
    }
}
