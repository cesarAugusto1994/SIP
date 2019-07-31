<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Document extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'client_documents';

    protected $fillable = ['file_id', 'type', 'client_id'];

    protected static $logAttributes = ['file_id', 'type', 'client_id'];

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Documento do Cliente atualizado";
        } elseif ($eventName == 'deleted') {
            return "Documento do Cliente Removido";
        }

        return "Novo Documento do Cliente Adicionado";
    }
}
