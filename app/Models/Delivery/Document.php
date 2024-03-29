<?php

namespace App\Models\Delivery;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Document extends Model
{
    use Uuids;

    protected $table = 'delivery_documents';

    protected $fillable = [
      'annotations', 'client_id',
      'employee_id', 'created_by',
      'status_id', 'type_id', 'address_id',
      'amount', 'extra_amount', 'reference'
    ];

    protected static $logAttributes = [
      'annotations', 'client_id',
      'employee_id', 'created_by',
      'status_id', 'type_id', 'address_id',
      'amount', 'extra_amount', 'reference'
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Client\Employee');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Client\Address');
    }

    public function delivery()
    {
        return $this->belongsTo('App\Models\DeliveryOrder');
    }

    public function deliveryDocument()
    {
        return $this->hasOne('App\Models\DeliveryOrder\Documents');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Delivery\Document\Status', 'status_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Delivery\Document\Type', 'type_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Documento atualizado";
        } elseif ($eventName == 'deleted') {
            return "Documento removido";
        }

        return "Documento Adicionado";
    }
}
