<?php

namespace App\Models\Stock\Stock;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Transfer extends Model
{
    use Uuids;

    protected $table = 'product_transfer';

    protected $fillable = ['user_id', 'subject', 'description', 'status',
    'localization', 'target_id', 'term_path', 'scheduled_to', 'withdrawn_at', 'returned_at'];

    protected static $logAttributes = ['user_id', 'subject', 'description', 'status',
    'localization', 'target_id', 'term_path', 'scheduled_to', 'withdrawn_at', 'returned_at'];

    protected $dates = ['scheduled_to', 'withdrawn_at', 'returned_at'];

    public function items()
    {
        return $this->hasMany('App\Models\Stock\Stock\Transfer\Item');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'target_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'target_id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit', 'target_id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Stock\Vendor', 'target_id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        if($eventName == 'updated') {
            return "Transferência do Ativo atualizado";
        } elseif ($eventName == 'deleted') {
            return "Transferência do Ativo Removido";
        }

        return "Transferência do Ativo adicionada";
    }
}
