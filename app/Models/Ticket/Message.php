<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Message extends Model
{
    use Uuids;

    protected $table = 'ticket_messages';

    protected $fillable = ['message', 'user_id', 'ticket_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
