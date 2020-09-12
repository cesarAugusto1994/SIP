<?php

namespace App\Models\ServiceOrder\ServiceOrder\Training;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Course extends Model
{
    use Uuids;

    protected $table = 'service_order_training_courses';

    protected $fillable = ['service_order_id', 'course_id'];

    public function serviceOrder()
    {
        return $this->belongsTo('App\Models\ServiceOrder\ServiceOrder', 'service_order_id');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Training\Course', 'course_id');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Training\Team', 'team_id');
    }
}
