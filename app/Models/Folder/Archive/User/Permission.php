<?php

namespace App\Models\Folder\Archive\User;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Permission extends Model
{
    use Uuids;

    protected $table = 'archive_user_permissions';

    protected $fillable = ['archive_id', 'user_id', 'read', 'edit', 'delete', 'share', 'download'];

    protected static $logAttributes = ['archive_id', 'user_id', 'read', 'edit', 'delete', 'share', 'download'];

    public function archive()
    {
       return $this->belongsTo('App\Models\Folder\Archive', 'archive_id');
    }

    public function user()
    {
       return $this->belongsTo('App\User', 'user_id');
    }
}
