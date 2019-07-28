<?php

namespace App\Models\Schedule;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
class Guest extends Model
{
    use Uuids;

    protected $table = 'schedule_guests';

    protected $fillable = ['user_id', 'schedule_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
