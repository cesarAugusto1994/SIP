<?php

namespace App\Models\ServiceOrder\ServiceOrder;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Ticket extends Model
{
    use Uuids;

    protected $table = 'service_order_tickets';

    protected $fillable = ['service_order_id', 'ticket_id', 'ticket_type_id'];

    public function type()
    {
        return $this->belongsTo('App\Models\Ticket\Type', 'ticket_type_id');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket', 'ticket_id');
    }
}
