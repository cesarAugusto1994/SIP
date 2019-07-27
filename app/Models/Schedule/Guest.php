<?php

namespace App\Models\Schedule;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Guest extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'schedule_guests';

    protected $fillable = ['user_id', 'schedule_id'];
}
