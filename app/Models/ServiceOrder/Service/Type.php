<?php

namespace App\Models\ServiceOrder\Service;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Type extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'service_types';

    protected $fillable = ['name', 'active'];
    protected static $logAttributes = ['name', 'active'];
}
