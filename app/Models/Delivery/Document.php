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
      'status_id', 'type_id',
      'price', 'extra_value'
    ];

    protected static $logAttributes = [
      'annotations', 'client_id',
      'employee_id', 'created_by',
      'status_id', 'type_id',
      'price', 'extra_value'
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

    public function status()
    {
        return $this->belongsTo('App\Models\Delivery\Document\Status', 'status_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Delivery\Document\Type', 'type_id');
    }
}
