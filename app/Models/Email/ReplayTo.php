<?php

namespace App\Models\Email;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class ReplayTo extends Model
{
    use Uuids;

    protected $table = 'email_reply_to';
    protected $fillable = ['email_id', 'contact_id'];

    public function contact()
    {
       return $this->belongsTo('App\Models\Email\Contact');
    }
}
