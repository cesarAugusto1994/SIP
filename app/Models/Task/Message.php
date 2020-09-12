<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Message extends Model
{
    use Uuids;
    
    protected $table = 'task_messages';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
