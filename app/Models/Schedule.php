<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Schedule\Message as ScheduleMessage;

class Schedule extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'schedules';

    protected $fillable = ['title', 'description', 'localization', 'start', 'end', 'all_day', 'type_id', 'type_id', 'user_id'];

    protected static $logAttributes = ['title', 'description', 'localization', 'start', 'end', 'all_day', 'type_id', 'type_id', 'user_id'];

    protected $dates = ['start', 'end'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Schedule\Message', 'schedule_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Schedule\Type');
    }

    public function guests()
    {
        return $this->hasMany('App\Models\Schedule\Guest');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'schedule_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Compromisso atualizado";
        } elseif ($eventName == 'deleted') {
            return "Compromisso removido";
        }

        return "Compromisso adicionado";
    }
}
