<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Ticket extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'tickets';

    protected $fillable = ['type_id', 'user_id', 'description', 'status_id', 'assigned_to', 'solved_at', 'priority'];

    protected static $logAttributes = ['type_id', 'user_id', 'status_id', 'description', 'assigned_to', 'solved_at', 'priority'];

    public function type()
    {
        return $this->belongsTo('App\Models\Ticket\Type', 'type_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Ticket\Status');
    }

    public function responsible()
    {
        return $this->belongsTo('App\User', 'assigned_to');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\Ticket\Status\Log', 'ticket_id');
    }

    public function serviceTicket()
    {
        return $this->hasOne('App\Models\ServiceOrder\Service\Ticket\Type', 'ticket_id');
    }

    public function serviceOrderTicket()
    {
        return $this->hasOne('App\Models\ServiceOrder\ServiceOrder\Ticket', 'ticket_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Ticket\Message');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Chamado atualizado";
        } elseif ($eventName == 'deleted') {
            return "Chamado Removido";
        }

        return "Chamado Adicionado";
    }
}
