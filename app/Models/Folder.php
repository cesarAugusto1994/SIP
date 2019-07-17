<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Folder extends Model
{
    use Uuids;

    protected $table = 'folders';

    protected $fillable = ['name', 'user_id', 'path', 'parent_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Folder', 'parent_id', 'id');
    }

    public function archives()
    {
       return $this->hasMany('App\Models\Folder\Archive');
    }

    public function folders()
    {
       return $this->hasMany('App\Models\Folder', 'parent_id');
    }
}
