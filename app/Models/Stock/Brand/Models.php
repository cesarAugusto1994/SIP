<?php

namespace App\Models\Stock\Brand;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Models extends Model
{
    use Uuids;
    use LogsActivity;

    protected $fillable = ['name', 'brand_id', 'active'];
    protected static $logAttributes = ['name', 'brand_id', 'active'];

    public function brand()
    {
        return $this->belongsTo('App\Models\Stock\Brand');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Modelo atualizado";
        } elseif ($eventName == 'deleted') {
            return "Modelo Removido";
        }

        return "Modelo adicionado";
    }
}
