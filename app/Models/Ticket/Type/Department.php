<?php

namespace App\Models\Ticket\Type;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Department extends Model
{
    use Uuids;

    protected $table = 'department_ticket_types';

    protected $fillable = ['department_id', 'type_id'];

    protected static $logAttributes = ['department_id', 'type_id'];

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Ticket\Type', 'type_id');
    }

    public function types()
    {
        return $this->hasMany('App\Models\Ticket\Type\Department', 'department_id');
    }
}
