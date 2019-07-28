<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Schedule extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'schedules';

    protected $fillable = ['title', 'description', 'localization', 'start', 'end', 'all_day', 'type_id', 'type_id', 'user_id'];

    protected static $logAttributes = ['title', 'description', 'localization', 'start', 'end', 'all_day', 'type_id', 'type_id', 'user_id'];

    protected $dates = ['start', 'end'];

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
}
