<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Type extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'ticket_types';

    protected $fillable = ['name', 'active', 'category_id'];

    protected static $logAttributes = ['name', 'active', 'category_id'];

    public function departments()
    {
        //return $this->hasManyThrough('App\Models\Ticket\Type\Department', 'App\Models\Department', 'id', 'department_id');

        return $this->hasMany('App\Models\Ticket\Type\Department', 'type_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Ticket\Type\Category', 'category_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Tipo de Chamado atualizado";
        } elseif ($eventName == 'deleted') {
            return "Tipo de Chamado Removido";
        }

        return "Tipo de Chamado Adicionado";
    }
}
