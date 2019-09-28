<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Table extends Model
{
    use Uuids;

    protected $fillable = ['name', 'label', 'database', 'description'];

    public function columns()
    {
        return $this->hasMany('App\Models\Report\Column');
    }

    public function queries()
    {
        return $this->hasMany('App\Models\Report\Query');
    }
}
