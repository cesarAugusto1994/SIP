<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Email extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'client_emails';

    protected $fillable = ['email', 'client_id', 'active'];

    protected static $logAttributes = ['email', 'client_id', 'active'];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "E-mail do Cliente atualizado";
        } elseif ($eventName == 'deleted') {
            return "E-mail do Cliente Removido";
        }

        return "Novo E-mail do Cliente Adicionado";
    }
}
