<?php

namespace App\Models\ServiceOrder;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Service extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'services';

    protected $fillable = ['name', 'active', 'description', 'service_type_id'];
    protected static $logAttributes = ['name', 'active', 'description', 'service_type_id'];

    public function values()
    {
        return $this->hasMany('App\Models\ServiceOrder\Service\Value');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\ServiceOrder\Service\Type', 'service_type_id');
    }

    public function ticketTypes()
    {
        return $this->hasMany('App\Models\ServiceOrder\Service\Ticket\Type', 'service_id');
    }

    public function courses()
    {
        return $this->hasMany('App\Models\ServiceOrder\Service\Training\Course', 'service_id');
    }
}
