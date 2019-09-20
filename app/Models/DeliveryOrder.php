<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class DeliveryOrder extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'delivery_order';

    protected $fillable = ['status_id', 'withdrawal_by_client', 'charge_delivery' ,'printed', 'user_id', 'email_notification', 'client_id', 'amount', 'delivered_by', 'finished_at', 'finished_by', 'address_id', 'delivered_at', 'delivery_date', 'receipt', 'annotations', 'delivery_date', 'created_at'];

    protected static $logAttributes = ['status_id', 'withdrawal_by_client', 'charge_delivery', 'printed', 'user_id', 'email_notification', 'client_id', 'amount', 'address_id', 'delivered_by', 'finished_at', 'finished_by', 'delivered_at', 'delivery_date', 'receipt', 'annotations', 'delivery_date'];

    protected $dates = ['delivery_date', 'delivery_at', 'delivered_at', 'created_at'];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function documents()
    {
        return $this->hasMany('App\Models\DeliveryOrder\Documents');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\DeliveryOrder\Log');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Client\Address');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\DeliveryOrder\Status');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'delivered_by');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Ordem de Entrega foi atualizada";
        } elseif ($eventName == 'deleted') {
            return "Ordem de Entrega removida";
        }

        return "Ordem de Entrega adicionada";
    }
}
