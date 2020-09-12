<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Column extends Model
{
    use Uuids;

    protected $fillable = ['name', 'label', 'type', 'is_primary_key', 'table_id', 'format_id', 'is_label', 'show'];

    public function table()
    {
        return $this->belongsTo('App\Models\Report\Table', 'table_id');
    }

    public function tableReference()
    {
        return $this->belongsTo('App\Models\Report\Table', 'table_reference_id');
    }

    public function format()
    {
        return $this->belongsTo('App\Models\Report\Format');
    }
}
