<?php

namespace App\Models\Folder\Archive\Group;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Permission extends Model
{
    use Uuids;

    protected $table = 'archive_group_permissions';

    protected $fillable = ['archive_id', 'group_id', 'read', 'edit', 'delete', 'share', 'download'];

    public function archive()
    {
       return $this->belongsTo('App\Models\Folder\Archive', 'archive_id');
    }

    public function group()
    {
       return $this->belongsTo('App\Models\Department', 'group_id');
    }
}
