<?php

namespace App\Models\Department;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Occupation extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'occupation';

    protected $fillable = ['name', 'department_id', 'active'];

    protected static $logAttributes = ['name', 'department_id', 'active'];

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

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
