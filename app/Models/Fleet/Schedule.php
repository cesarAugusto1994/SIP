<?php

namespace App\Models\Fleet;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Schedule extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'fleet_schedules';

    protected $dates = ['start', 'end'];

    protected $fillable = ['vehicle_id', 'driver_id', 'status_id', 'vacancies', 'start', 'end', 'reason', 'ride_to', 'user_id', 'approved', 'approved_by'];

    protected static $logAttributes = ['vehicle_id', 'driver_id', 'status_id', 'vacancies', 'start', 'end', 'reason', 'ride_to', 'user_id', 'approved', 'approved_by'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function driver()
    {
        return $this->belongsTo('App\User', 'driver_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Fleet\Schedule\Status');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Models\Fleet\Vehicle');
    }

    public function guests()
    {
        return $this->hasMany('App\Models\Fleet\Schedule\Guest');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Agendamento de veículo atualizado";
        } elseif ($eventName == 'deleted') {
            return "Agendamento de veículo cancelado";
        }

        return "Agendamento de veículo adicionado";
    }
}
