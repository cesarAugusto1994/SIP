<?php

namespace App\Models\Email;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Folder extends Model
{
    use Uuids;

    protected $table = 'email_folders';

    protected $fillable = [
      'name', 'full_name', 'path', 'delimiter',
      'no_inferiors', 'no_select', 'marked',
      'has_children', 'referal'
    ];
}
