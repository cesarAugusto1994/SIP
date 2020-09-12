<?php

namespace App\Models\Client\Employee;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'employee_courses';

    protected $fillable = ['employee_id', 'course_id', 'required', 'frequency', 'created_by'];
}
