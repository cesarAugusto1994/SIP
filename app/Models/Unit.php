<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Unit extends Model
{
    use Uuids;

    protected $table = 'units';

    protected $fillable = ['name', 'address', 'workload'];
}
