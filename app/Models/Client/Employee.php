<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{
    use Uuids;
    use LogsActivity;

    protected $fillable = ['name', 'email', 'phone', 'cpf', 'code',
    'biometric', 'created_by', 'active',
    'birth','hired_at','fired_at', 'rg'];

    protected static $logAttributes = ['name', 'email', 'phone', 'cpf', 'code',
    'biometric', 'created_by', 'active',
    'birth','hired_at','fired_at', 'rg'];

    protected $table = 'client_employees';

    protected $dates = ['birth','hired_at','fired_at'];

    public function company()
    {
        return $this->belongsTo('App\Models\Client', 'company_id');
    }

    public function jobs()
    {
        return $this->hasMany('App\Models\Client\Employee\Job', 'employee_id');
    }

    public function occupations()
    {
        return $this->hasMany('App\Models\Client\Employee\Occupation', 'employee_id');
    }

    public function companies()
    {
        return $this->hasManyThrough('App\Models\Client', 'App\Models\Client\Employee\Job');
    }

    public function trainings()
    {
        return $this->hasMany('App\Models\Training\Team\Employee', 'employee_id');
    }

    public function occupation()
    {
        return $this->belongsTo('App\Models\Client\Occupation', 'occupation_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Funcionário atualizado";
        } elseif ($eventName == 'deleted') {
            return "Funcionário Removido";
        }

        return "Funcionário Adicionado";
    }
}
