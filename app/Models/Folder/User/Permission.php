<?php

namespace App\Models\Folder\User;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'folder_user_permissions';

    protected $fillable = ['folder_id', 'user_id', 'read', 'edit', 'delete', 'share'];

    protected static $logAttributes = ['folder_id', 'user_id', 'read', 'edit', 'delete', 'share'];

    public function folder()
    {
       return $this->belongsTo('App\Models\Folder', 'folder_id');
    }
}
