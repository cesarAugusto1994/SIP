<?php

namespace App\Models\Fleet;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Vehicle extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'vehicles';

    protected $dates = ['bought_at', 'last_maintenance'];

    protected $fillable = ['name', 'description', 'model', 'brand', 'year', 'bought_at', 'last_maintenance', 'status_id', 'active', 'inactivated_at'];

    protected static $logAttributes = ['name', 'description', 'model', 'brand', 'year', 'bought_at', 'last_maintenance', 'status_id', 'active', 'inactivated_at'];

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Veículo atualizado";
        } elseif ($eventName == 'deleted') {
            return "Veículo removido";
        }

        return "Veículo adicionado";
    }
}
