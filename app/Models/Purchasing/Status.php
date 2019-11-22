<?php

namespace App\Models\Purchasing;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Status extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'purchasing_status';

    protected $fillable = ['name'];

    protected static $logAttributes = ['name'];
}
