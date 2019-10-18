<?php

namespace App\Models\ServiceOrder\ServiceOrder;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Item extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'service_order_items';

    protected $dates = ['deadline'];

    protected $fillable = ['service_order_id', 'service_id', 'status_id', 'quantity', 'observation', 'deadline', 'user_id', 'original_value', 'value'];
    protected static $logAttributes = ['service_order_id', 'service_id', 'status_id', 'quantity', 'observation', 'deadline', 'user_id', 'original_value', 'value'];

    public function service()
    {
        return $this->belongsTo('App\Models\ServiceOrder\Service');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
