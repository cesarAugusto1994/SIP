<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Occupation extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'client_occupations';

    protected $fillable = ['name', 'active'];

    protected static $logAttributes = ['name', 'active'];

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Cargo atualizado";
        } elseif ($eventName == 'deleted') {
            return "Cargo Removido";
        }

        return "Cargo Adicionado";
    }
}
