<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Pause extends Model
{
    use Uuids;
    
    protected $table = 'task_pauses';
}
