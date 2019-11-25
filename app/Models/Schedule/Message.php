<?php

namespace App\Models\Schedule;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Message extends Model
{
    use Uuids;

    protected $table = 'schedule_messages';

    protected $fillable = ['user_id', 'schedule_id', 'message'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function schedule()
    {
        return $this->belongsTo('App\Models\Schedule');
    }
}
