<?php

namespace App\Models\Fleet\Schedule;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Guest extends Model
{
    use Uuids;

    protected $table = 'fleet_schedule_guests';

    protected $fillable = ['user_id', 'schedule_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function schedules()
    {
        return $this->hasMany('App\Models\Fleet\Schedule', 'user_id');
    }
}
