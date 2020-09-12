<?php

use Illuminate\Database\Seeder;
use App\Models\Fleet\Vehicle\Status;
use App\Models\Fleet\Schedule\Status as ScheduleStatus;

class VehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['Disponível', 'Em Manutenção'];

        foreach ($statuses as $key => $value) {
            Status::updateOrCreate([
              'name' => $value,
            ]);
        }

        $statuses = ['Disponível', 'Agendado', 'Em Uso'];

        foreach ($statuses as $key => $value) {
            ScheduleStatus::updateOrCreate([
              'name' => $value,
            ]);
        }
    }
}
