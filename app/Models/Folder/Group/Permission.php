<?php

namespace App\Models\Folder\Group;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'folder_group_permissions';

    protected $fillable = ['folder_id', 'group_id', 'read', 'edit', 'delete', 'share'];

    protected static $logAttributes = ['folder_id', 'group_id', 'read', 'edit', 'delete', 'share'];

    public function folder()
    {
       return $this->belongsTo('App\Models\Folder', 'folder_id');
    }
}
