<?php

namespace App\Models\DeliveryOrder;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Log extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'delivery_order_logs';

    protected $fillable = ['status_id', 'delivery_order_id', 'user_id', 'message'];

    protected static $logAttributes = ['status_id', 'delivery_order_id', 'user_id', 'message'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
