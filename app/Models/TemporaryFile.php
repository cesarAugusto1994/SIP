<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class TemporaryFile extends Model
{
    use Uuids;

    protected $table = 'temporary_files';

    protected $fillable = ['path', 'user_id'];
}
