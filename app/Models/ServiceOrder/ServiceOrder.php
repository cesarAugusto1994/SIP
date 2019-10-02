<?php

namespace App\Models\ServiceOrder;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class ServiceOrder extends Model
{
  use Uuids;
  use LogsActivity;

  protected $table = 'service_orders';

  protected $fillable = ['client_id', 'contract_id', 'status_id'];
  protected static $logAttributes = ['client_id', 'contract_id', 'status_id'];

  public function client()
  {
      return $this->belongsTo('App\Models\Client', 'client_id');
  }

  public function contract()
  {
      return $this->belongsTo('App\Models\Contract', 'contract_id');
  }

  public function status()
  {
      return $this->belongsTo('App\Models\ServiceOrder\ServiceOrder\Status', 'status_id');
  }
}
