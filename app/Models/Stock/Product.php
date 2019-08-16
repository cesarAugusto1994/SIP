<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use Uuids;
    use LogsActivity;

    protected $fillable = ['name', 'description', 'brand_id', 'model_id',
                            'vendor_id', 'lifetime', 'lifetime_type',
                            'min_stock', 'max_stock', 'actual_stock', 'user_id'];

    protected static $logAttributes = ['name', 'description', 'brand_id', 'model_id',
                            'vendor_id', 'lifetime', 'lifetime_type',
                            'min_stock', 'max_stock', 'actual_stock', 'user_id'];

    public function stocks()
    {
        return $this->hasMany('App\Models\Stock\Stock');
    }

    public function model()
    {
        return $this->belongsTo('App\Models\Stock\Brand\Models');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Stock\Brand');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Stock\Vendor');
    }
}
