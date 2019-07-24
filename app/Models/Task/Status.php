<?php

namespace App\Models\Task;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Status extends Model
{
    use Uuids;

    protected $table = 'task_status';

    protected $fillable = ['name'];
}
