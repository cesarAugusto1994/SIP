<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Stock extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'stock';

    protected $fillable = ['product_id', 'registration_code', 'equity_registration_code', 'buyed_at', 'serial',
                            'status', 'localization', 'user_id', 'department_id', 'unity_id', 'vendor_id'];

    protected static $logAttributes = ['product_id', 'registration_code', 'equity_registration_code', 'serial', 'buyed_at',
                            'status', 'localization', 'user_id', 'department_id', 'unity_id', 'vendor_id'];

    protected $dates = ['buyed_at'];

    public function product()
    {
        return $this->belongsTo('App\Models\Stock\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit', 'unity_id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Stock\Vendor');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Estoque do Ativo atualizado";
        } elseif ($eventName == 'deleted') {
            return "Estoque do Ativo Removido";
        }

        return "Estoque adicionado ao Ativo";
    }
}
