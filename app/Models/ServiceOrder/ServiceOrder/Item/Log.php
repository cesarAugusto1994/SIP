<?php

namespace App\Models\ServiceOrder\ServiceOrder\Item;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Log extends Model
{
    use Uuids;

    protected $table = 'service_order_item_logs';

    protected $fillable = ['message','annotations','status_id','user_id'];
}
