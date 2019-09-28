<?php

use Illuminate\Database\Seeder;
use App\Models\Report\{Format};

class FormatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = ['Texto', 'Numerico', 'Valor', 'Booleano Situação', 'Booleano Confirmação', 'Data', 'Data Hora', 'Enum'];

        foreach ($items as $key => $item) {
            Format::create([
              'name' => $item,
              'label' => $item,
            ]);
        }
    }
}
