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

  protected $fillable = ['client_id', 'contract_id', 'status_id', 'contact_id',
  'amount', 'input_value', 'due_date', 'installment_quantity',
  'installment_date', 'installment_value', 'discount',
  'client_data_solicitation_date', 'client_feedback_date', 'release_date',
  'completed_service', 'client_data_solicitation_date'];

  protected static $logAttributes = ['client_id', 'contract_id', 'status_id', 'contact_id',
  'amount', 'input_value', 'due_date', 'installment_quantity',
  'installment_date', 'installment_value', 'discount',
  'client_data_solicitation_date', 'client_feedback_date', 'release_date',
  'completed_service', 'client_data_solicitation_date'];

  protected $dates = ['due_date', 'installment_date', 'client_data_solicitation_date', 'client_feedback_date',
  'release_date',
  'client_data_solicitation_date'];

  public function client()
  {
      return $this->belongsTo('App\Models\Client', 'client_id');
  }

  public function user()
  {
      return $this->belongsTo('App\User', 'user_id');
  }

  public function contract()
  {
      return $this->belongsTo('App\Models\Contract', 'contract_id');
  }

  public function contact()
  {
      return $this->belongsTo('App\Models\Client\Employee', 'contact_id');
  }

  public function status()
  {
      return $this->belongsTo('App\Models\ServiceOrder\ServiceOrder\Status', 'status_id');
  }

  public function services()
  {
      return $this->hasMany('App\Models\ServiceOrder\ServiceOrder\Item');
  }

  public function addresses()
  {
      return $this->hasMany('App\Models\ServiceOrder\ServiceOrder\Address');
  }
}
