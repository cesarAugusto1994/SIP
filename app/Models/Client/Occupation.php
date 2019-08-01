<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Occupation extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'client_occupations';

    protected $fillable = ['name', 'active'];

    protected static $logAttributes = ['name', 'active'];
}
