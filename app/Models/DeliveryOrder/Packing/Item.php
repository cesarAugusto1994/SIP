<?php

namespace App\Models\DeliveryOrder\Packing;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Item extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'delivery_packing_items';

    protected $fillable = ['packing_id', 'delivery_id', 'delivered'];

    protected static $logAttributes = ['packing_id', 'delivery_id', 'delivered'];

    public function packing()
    {
        return $this->belongsTo('App\Models\DeliveryOrder\Packing');
    }

    public function delivery()
    {
        return $this->belongsTo('App\Models\DeliveryOrder');
    }
}
