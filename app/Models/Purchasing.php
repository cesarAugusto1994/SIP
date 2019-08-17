<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Purchasing extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'purchasings';

    protected $fillable = ['motive', 'observations', 'status', 'user_id', 'delivery_forecast', 'delivery_at', 'buyed_at', 'approved_by'];

    protected static $logAttributes = ['motive', 'observations', 'status', 'user_id', 'delivery_forecast', 'delivery_at', 'buyed_at', 'approved_by'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Purchasing\Item', 'purchasing_id');
    }
}
