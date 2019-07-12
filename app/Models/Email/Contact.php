<?php

namespace App\Models\Email;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Contact extends Model
{
    use Uuids;

    protected $table = 'email_contacts';

    protected $fillable = [
      'personal', 'mailbox', 'host', 'mail', 'full', 'active', 'user_id'
    ];
}
