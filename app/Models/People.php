<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class People extends Model
{
    use Uuids;
    use LogsActivity;

    protected $fillable = ['name', 'department_id', 'occupation_id', 'registry', 'cpf', 'birthday', 'unit_id', 'branch', 'phone', 'phone_code', 'phone_password', 'phone_callcenter_code'];

    protected static $logAttributes = ['name', 'department_id', 'occupation_id', 'registry', 'cpf', 'birthday', 'unit_id', 'branch', 'phone', 'phone_code', 'phone_password', 'phone_callcenter_code'];

    protected $dates = ['birthday'];

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    public function ticketTypesDepartment()
    {
        return $this->belongsTo('App\Models\Ticket\Type\Department', 'department_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'person_id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }

    public function occupation()
    {
        return $this->belongsTo('App\Models\Department\Occupation');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Dados do usuário atualizados";
        } elseif ($eventName == 'deleted') {
            return "Dados do usuário removidos";
        }

        return "Dados do usuário adicionados";
    }
}
