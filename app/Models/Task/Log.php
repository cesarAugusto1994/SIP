<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Log extends Model
{
    use Uuids;

    protected $table = 'task_logs';

    protected $fillable = [
        'task_id', 'user_id', 'message', 'status_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
