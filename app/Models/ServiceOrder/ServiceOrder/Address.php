<?php

namespace App\Models\ServiceOrder\ServiceOrder;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Address extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'service_order_addresses';

    protected $fillable = ['service_order_id', 'client_id', 'address_id'];
    protected static $logAttributes = ['service_order_id', 'client_id', 'address_id'];

    public function service()
    {
        return $this->belongsTo('App\Models\ServiceOrder\Service');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Client\Address');
    }
}
