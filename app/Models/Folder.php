<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Folder extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'folders';

    protected $fillable = ['name', 'user_id', 'path', 'parent_id'];

    protected static $logAttributes = ['name', 'user_id', 'path', 'parent_id'];

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

    public function children()
    {
       return $this->hasMany('App\Models\Folder', 'parent_id');
    }

    public function permissionsForGroup()
    {
       return $this->hasManyThrough('App\Models\Folder\Group\Permission', 'App\Models\Department', 'folder_id', 'group_id');
    }

    public function permissionsForUser()
    {
       return $this->hasManyThrough('App\Models\Folder\User\Permission', 'App\User', 'folder_id', 'user_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Pasta atualizada";
        } elseif ($eventName == 'deleted') {
            return "Pasta Deletada";
        }

        return "Pasta Criada";
    }
}
