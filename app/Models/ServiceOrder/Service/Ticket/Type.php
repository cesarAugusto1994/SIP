<?php

namespace App\Models\ServiceOrder\Service\Ticket;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Type extends Model
{
    use Uuids;

    protected $table = 'service_ticket_types';

    protected $fillable = ['service_id', 'ticket_type_id'];

    public function service()
    {
        return $this->belongsTo('App\Models\ServiceOrder\Service', 'service_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Ticket\Type', 'ticket_type_id');
    }
}
