<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;
use App\User;

class Task extends Model
{
    use Uuids;
    use LogsActivity;

    const STATUS_PENDENTE = 1;
    const STATUS_EM_ANDAMENTO = 2;
    const STATUS_FINALIZADO = 3;
    const STATUS_CANCELADO = 4;

    protected $fillable = [
        'name', 'description', 'user_id',
        'frequency', 'time', 'schedule_id',
        'client_id', 'ticket_id', 'created_at', 'client_id',
        'severity', 'urgency', 'trend', 'sponsor_id',
        'status_id', 'requester_id', 'active', 'time_type',
        'percent_conclusion', 'start', 'end', 'parent_id'
    ];

    protected static $logAttributes = [
      'name', 'description', 'user_id',
      'frequency', 'time', 'schedule_id',
      'client_id', 'ticket_id', 'created_at',
      'severity', 'urgency', 'trend', 'sponsor_id', 'client_id',
      'status_id', 'requester_id', 'active', 'time_type',
      'percent_conclusion', 'start', 'end', 'parent_id'
    ];

    protected $dates = ['start', 'end'];

    public function subprocess()
    {
        return $this->belongsTo(SubProcesses::class, 'sub_process_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket', 'ticket_id');
    }

    public function client()
    {
        return $this->belongsTo(Department::class, 'client_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Department::class, 'vendor_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Ticket\Status', 'status_id');
    }

    public function sponsor()
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function mapper()
    {
        return $this->belongsTo(Mapper::class, 'mapper_id');
    }

    public function owner()
    {
        return $this->belongsTo(Client::class, 'owner_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\Task\log');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Task\Message');
    }

    public function files()
    {
        return $this->hasMany('App\Models\Task\Archive');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Tarefa atualizada";
        } elseif ($eventName == 'deleted') {
            return "Tarefa removida";
        }

        return "Tarefa adicionada";
    }
}
