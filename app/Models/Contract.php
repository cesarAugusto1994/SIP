<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Contract extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'contracts';

    protected $fillable = ['name', 'active'];

    protected static $logAttributes = ['name', 'active'];
}
