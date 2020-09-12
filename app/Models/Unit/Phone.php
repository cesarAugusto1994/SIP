<?php

namespace App\Models\Unit;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Phone extends Model
{
    use Uuids;

    protected $table = 'unit_phones';

    protected $fillable = ['number', 'unit_id'];
}
