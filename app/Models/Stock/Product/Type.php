<?php

namespace App\Models\Stock\Product;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Type extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'product_types';

    protected $fillable = ['name', 'active'];
    protected static $logAttributes = ['name', 'active'];
}
