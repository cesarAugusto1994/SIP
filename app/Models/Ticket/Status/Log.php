<?php

namespace App\Models\Ticket\Status;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Log extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'ticket_status_logs';

    protected $fillable = ['ticket_id', 'status_id', 'description'];

    protected static $logAttributes = ['ticket_id', 'status_id', 'description'];

    public function status()
    {
        return $this->belongsTo('App\Models\Ticket\Status', 'status_id');
    }
}
