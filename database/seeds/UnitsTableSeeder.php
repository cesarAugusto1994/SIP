<?php

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = ['Vitória', 'Vila Velha Centro', 'Vila Velha Ibes', 'Serra', 'Cariacica', 'Baixo Guandú'];

        foreach ($itens as $key => $item) {
            Unit::create(['name' => $item]);
        }
    }
}
