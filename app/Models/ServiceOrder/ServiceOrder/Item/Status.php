<?php

namespace App\Models\ServiceOrder\ServiceOrder\Item;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Status extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'service_order_item_statuses';

    protected $fillable = ['name'];
    protected static $logAttributes = ['name'];
}
