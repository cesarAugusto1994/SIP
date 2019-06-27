<?php

namespace App\Models\Ticket\Type;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'department_ticket_types';

    protected $fillable = ['department_id', 'type_id'];

    protected static $logAttributes = ['department_id', 'type_id'];

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }
}
