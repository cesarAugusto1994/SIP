<?php

namespace App\Models\Client\Employee;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    protected $table = 'employee_occupations';
    protected $fillable = ['employee_id', 'occupation_id', 'active'];

    public function occupation()
    {
        return $this->belongsTo('App\Models\Client\Occupation', 'occupation_id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Client\Employee', 'employee_id');
    }
}
