<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['title', 'route', 'permission', 'description', 'parent'];

    public function childs()
    {
         return $this->hasMany('App\Models\Menu', 'parent');
    }
}
