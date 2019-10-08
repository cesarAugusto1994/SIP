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

    protected $fillable = ['service_order_id', 'service_id'];
    protected static $logAttributes = ['service_order_id', 'service_id'];

    public function service()
    {
        return $this->belongsTo('App\Models\ServiceOrder\Service');
    }
}
