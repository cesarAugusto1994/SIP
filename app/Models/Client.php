<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model
{
    use Uuids;
    use LogsActivity;

    protected $fillable = ['name', 'code', 'charge_delivery', 'contract_id', 'document', 'deliver_documents', 'active'];

    protected static $logAttributes = ['name', 'code', 'charge_delivery', 'contract_id', 'document', 'deliver_documents', 'active'];

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract');
    }

    public function phones()
    {
        return $this->hasMany('App\Models\Client\Phone', 'client_id');
    }

    public function emails()
    {
        return $this->hasMany('App\Models\Client\Email', 'client_id');
    }

    public function documents()
    {
        return $this->hasMany('App\Models\Delivery\Document', 'client_id');
    }

    public function files()
    {
        return $this->hasMany('App\Models\Documents', 'client_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Client\Address', 'client_id');
    }

    public function employees()
    {
        return $this->hasMany('App\Models\Client\Employee', 'company_id');
    }

    public function deliveries()
    {
        return $this->hasMany('App\Models\DeliveryOrder', 'client_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Cliente atualizado";
        } elseif ($eventName == 'deleted') {
            return "Cliente Removido";
        }

        return "Cliente Adicionado";
    }
}
