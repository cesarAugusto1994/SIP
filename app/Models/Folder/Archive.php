<?php

namespace App\Models\Folder;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Archive extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'archives';

    protected $fillable = ['folder_id', 'filename', 'size', 'type', 'content', 'extension', 'user_id', 'path'];

    protected static $logAttributes = ['folder_id', 'filename', 'size', 'type', 'content', 'extension', 'user_id', 'path'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function permissionsForGroup()
    {
       return $this->hasMany('App\Models\Folder\Archive\Group\Permission', 'group_id');
    }

    public function permissionsForUser()
    {
       return $this->hasMany('App\Models\Folder\Archive\User\Permission', 'archive_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Arquivo atualizado";
        } elseif ($eventName == 'deleted') {
            return "Arquivo Deletado";
        }

        return "Arquivo Adicionado";
    }
}
