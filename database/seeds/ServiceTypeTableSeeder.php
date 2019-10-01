<?php

use Illuminate\Database\Seeder;
use App\Models\ServiceOrder\Service\Type;

class ServiceTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = ['Exames', 'Treinamentos', 'Elaboração de Programas', 'Visita Técnica', 'Avaliação'];

        foreach ($items as $key => $item) {
            Type::create(['name' => $item]);
        }
    }
}
