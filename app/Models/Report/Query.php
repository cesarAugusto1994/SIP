<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Query extends Model
{
    use Uuids;

    protected $fillable = ['name', 'label', 'query', 'description', 'table_id', 'type', 'is_query_string'];

    public function parameters()
    {
        return $this->hasMany('App\Models\Report\Parameter');
    }

    public function table()
    {
        return $this->belongsTo('App\Models\Report\Table', 'table_id');
    }
}
