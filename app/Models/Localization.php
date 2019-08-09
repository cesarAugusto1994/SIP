<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localization extends Model
{
    protected $table = 'localizations';

    protected $fillable = ['user_id', 'lat', 'long'];
}
