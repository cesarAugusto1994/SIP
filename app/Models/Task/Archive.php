<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Archive extends Model
{
    use Uuids;
    
    protected $table = 'task_archives';

    protected $fillable = ['filename', 'path', 'user_id', 'task_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
