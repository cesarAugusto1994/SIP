<?php

namespace App\Models\Stock\Brand;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Models extends Model
{
    use Uuids;
    use LogsActivity;

    protected $fillable = ['name'];
    protected static $logAttributes = ['name'];
}
