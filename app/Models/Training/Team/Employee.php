<?php

namespace App\Models\Training\Team;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'team_employees';

    protected $fillable = ['team_id', 'employee_id', 'status', 'approved'];

    protected static $logAttributes = ['team_id', 'employee_id', 'status', 'approved'];

    public function employee()
    {
        return $this->belongsTo('App\Models\Client\Employee');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Training\Team');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Funcionário da Turma foi atualizado";
        } elseif ($eventName == 'deleted') {
            return "Funcionário Removido da Turma";
        }

        return "Funcionário Adicionada à Turma";
    }
}
