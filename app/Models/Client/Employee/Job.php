<?php

namespace App\Models\Client\Employee;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'employee_jobs';
    protected $fillable = ['employee_id', 'company_id', 'hired_at', 'fired_at', 'active'];

    protected $dates = ['hired_at', 'fired_at'];

    public function company()
    {
        return $this->belongsTo('App\Models\Client', 'company_id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Client\Employee', 'employee_id');
    }
}
