<?php

namespace App\Models\ServiceOrder\Service\Training;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Course extends Model
{
    use Uuids;

    protected $table = 'service_training_courses';

    protected $fillable = ['service_id', 'course_id'];

    public function service()
    {
        return $this->belongsTo('App\Models\ServiceOrder\Service', 'service_id');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Training\Course', 'course_id');
    }
}
