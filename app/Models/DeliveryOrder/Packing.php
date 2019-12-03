<?php

namespace App\Models\DeliveryOrder;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Packing extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'delivery_packings';

    protected $fillable = ['delivery_date', 'delivered_by', 'user_id'];

    protected $dates = ['delivery_date'];

    protected static $logAttributes = ['delivery_date', 'delivered_by', 'user_id'];

    public function items()
    {
        return $this->hasMany('App\Models\DeliveryOrder\Packing\Item', 'packing_id');
    }

    public function deliver()
    {
        return $this->belongsTo('App\User', 'delivered_by');
    }
}
