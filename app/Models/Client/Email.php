<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Email extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'client_emails';

    protected $fillable = ['email', 'client_id', 'active'];

    protected static $logAttributes = ['email', 'client_id', 'active'];
}
