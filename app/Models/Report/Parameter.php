<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Parameter extends Model
{
    use Uuids;

    protected $fillable = ['name', 'label', 'description', 'query', 'query_id', 'column_id', 'table_id', 'type', 'is_query_string'];

    public function queryParent()
    {
        return $this->belongsTo('App\Models\Report\Query', 'query_id');
    }

    public function column()
    {
        return $this->belongsTo('App\Models\Report\Column', 'column_id');
    }
}
