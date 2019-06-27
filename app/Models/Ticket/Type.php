<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Type extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'ticket_types';

    protected $fillable = ['name', 'active'];

    protected static $logAttributes = ['name', 'active'];

    public function departments()
    {
        //return $this->hasManyThrough('App\Models\Ticket\Type\Department', 'App\Models\Department', 'id', 'department_id');

        return $this->hasMany('App\Models\Ticket\Type\Department', 'type_id');
    }
}
