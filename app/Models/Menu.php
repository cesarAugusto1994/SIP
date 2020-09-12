<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['title', 'route', 'permission', 'description', 'parent', 'icon', 'order', 'active'];

    public function childs()
    {
         return $this->hasMany('App\Models\Menu', 'parent');
    }

    public function parentRow()
    {
         return $this->belongsTo('App\Models\Menu');
    }
}
