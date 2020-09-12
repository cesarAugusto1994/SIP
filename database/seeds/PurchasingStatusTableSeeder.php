<?php

use Illuminate\Database\Seeder;
use App\Models\Purchasing\Status;

class PurchasingStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = ['Aberto', 'Em Edição', 'Solicitado', 'Em Captação de Orçamentos', 'Aprovado', 'Negado', 'Cancelado'];

        foreach ($items as $key => $item) {
            Status::create([
              'name' => $item,
            ]);
        }
    }
}
