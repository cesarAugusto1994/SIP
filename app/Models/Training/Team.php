<?php

namespace App\Models\Training;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Team extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'teams';

    protected $fillable = ['course_id', 'teacher_id', 'presence_list', 'status', 'vacancies', 'start', 'end', 'description', 'localization'];

    protected $dates = ['start', 'end'];

    protected static $logAttributes = ['course_id', 'teacher_id', 'presence_list', 'status', 'vacancies', 'start', 'end', 'description', 'localization'];

    public function course()
    {
       return $this->belongsTo('App\Models\Training\Course');
    }

    public function teacher()
    {
       return $this->belongsTo('App\User', 'teacher_id');
    }

    public function employees()
    {
        return $this->hasMany('App\Models\Training\Team\Employee');
    }

    public function schedule()
    {
        return $this->hasMany('App\Models\Training\Team\Lessons');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Turma atualizada";
        } elseif ($eventName == 'deleted') {
            return "Turma Removida";
        }

        return "Turma Adicionada";
    }
}
