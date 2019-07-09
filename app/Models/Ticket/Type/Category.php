<?php

namespace App\Models\Ticket\Type;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use App\Models\Ticket;

class Category extends Model
{
    use Uuids;

    protected $table = 'ticket_type_categories';

    protected $fillable = ['name', 'active'];

    public function types()
    {
        return $this->hasMany('App\Models\Ticket\Type', 'category_id');
    }
}
