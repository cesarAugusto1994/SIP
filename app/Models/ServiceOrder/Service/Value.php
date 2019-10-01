<?php

namespace App\Models\ServiceOrder\Service;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Value extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'service_values';

    protected $fillable = ['service_id', 'cost', 'value', 'contract_id', 'active'];
    protected static $logAttributes = ['service_id', 'cost', 'value', 'contract_id', 'active'];

    public function service()
    {
        return $this->belongsTo('App\Models\ServiceOrder\Service');
    }

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract');
    }
}
