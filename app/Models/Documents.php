<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Documents extends Model
{
    use Uuids;
    use LogsActivity;

    protected $fillable = ['annotations', 'client_id', 'employee_id', 'type_id', 'created_by', 'status_id', 'price', 'link', 'filename', 'extension'];

    protected static $logAttributes = ['annotations', 'client_id', 'employee_id', 'type_id', 'created_by', 'price', 'link', 'filename', 'extension'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Client\Employee');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Documents\Status', 'status_id');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Client\Address', 'address_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Documents\Type', 'type_id');
    }
}
