<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Vendor extends Model
{
    use Uuids;
    use LogsActivity;

    protected $fillable = ['name', 'phone', 'email', 'active'];
    protected static $logAttributes = ['name', 'phone', 'email', 'active'];
}
