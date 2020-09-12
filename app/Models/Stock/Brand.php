<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Brand extends Model
{
    use Uuids;
    use LogsActivity;

    protected $fillable = ['name', 'active'];
    protected static $logAttributes = ['name', 'active'];

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Marca atualizada";
        } elseif ($eventName == 'deleted') {
            return "Marca Removida";
        }

        return "Marca adicionada";
    }
}
