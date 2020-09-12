<?php

use Illuminate\Database\Seeder;
use App\Models\Schedule\Type;

class ScheduleTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = ['Evento','Reunião', 'Visita à Cliente', 'Aniversário', 'Feriado', 'Férias'];

        foreach ($itens as $key => $value) {
            Type::create(['name' => $value]);
        }
    }
}
