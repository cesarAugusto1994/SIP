<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Module extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['name', 'slug', 'description', 'route', 'parent'];

    protected $fillable = ['name', 'slug', 'description', 'route', 'parent'];

    public function children()
    {
        return $this->hasMany('App\Models\Module', 'parent');
    }

    public function permissions()
    {
        return $this->hasMany('jeremykenedy\LaravelRoles\Models\Permission', 'module_id');
    }
}
