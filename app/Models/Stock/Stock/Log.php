<?php

namespace App\Models\Stock\Stock;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Log extends Model
{
    use Uuids;

    protected $table = 'stock_logs';

    protected $fillable = ['stock_id', 'user_id', 'message', 'status', 'localization', 'target_id'];
}
