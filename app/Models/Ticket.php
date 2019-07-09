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

    protected $fillable = ['type_id', 'user_id', 'description', 'assigned_to', 'solved_at'];

    protected static $logAttributes = ['type_id', 'user_id', 'description', 'assigned_to', 'solved_at'];

    public function type()
    {
        return $this->belongsTo('App\Models\Ticket\Type', 'type_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function responsible()
    {
        return $this->belongsTo('App\User', 'assigned_to');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\Ticket\Status\Log', 'ticket_id');
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
