<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Format extends Model
{
    use Uuids;

    const TYPE_TEXT = 1;
    const TYPE_NUMBER = 2;
    const TYPE_MONEY = 3;
    const TYPE_BOOLEAN_SITUATION = 4;
    const TYPE_BOOLEAN_CONFIRMATION = 5;
    const TYPE_DATE = 6;
    const TYPE_DATE_TIME = 7;
    const TYPE_ENUM = 8;

    const DATA_TYPE_INT = 'int';

    protected $fillable = ['name', 'label'];
}
