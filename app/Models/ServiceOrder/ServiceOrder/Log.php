<?php

namespace App\Models\ServiceOrder\ServiceOrder;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Log extends Model
{
    use Uuids;

    protected $table = 'service_order_logs';

    protected $fillable = ['message','service_order_id','status_id','user_id'];
}
