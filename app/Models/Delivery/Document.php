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
}
