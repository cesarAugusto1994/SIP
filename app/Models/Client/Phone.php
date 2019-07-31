<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Phone extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'client_phones';

    protected $fillable = ['number', 'client_id', 'active'];

    protected static $logAttributes = ['number', 'client_id', 'active'];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Telefone do Cliente atualizado";
        } elseif ($eventName == 'deleted') {
            return "Telefone do Cliente Removido";
        }

        return "Novo Telefone do Cliente Adicionado";
    }
}
