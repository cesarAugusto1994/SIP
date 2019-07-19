<?php

namespace App\Models\Folder\Group;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Permission extends Model
{
    use Uuids;

    protected $table = 'folder_group_permissions';

    protected $fillable = ['folder_id', 'group_id', 'read', 'edit', 'delete', 'share', 'download'];

    protected static $logAttributes = ['folder_id', 'group_id', 'read', 'edit', 'delete', 'share', 'download'];

    public function folder()
    {
       return $this->belongsTo('App\Models\Folder', 'folder_id');
    }
}
