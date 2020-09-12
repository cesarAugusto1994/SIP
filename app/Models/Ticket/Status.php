<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Status extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'ticket_statuses';

    protected $fillable = ['name', 'active'];

    protected static $logAttributes = ['name', 'active'];
}
