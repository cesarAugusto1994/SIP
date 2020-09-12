<?php

namespace App\Models\Stock\Stock\Transfer;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Item extends Model
{
    use Uuids;

    protected $table = 'product_transfer_item';

    protected $fillable = ['stock_id', 'transfer_id'];

    public function stock()
    {
        return $this->belongsTo('App\Models\Stock\Stock');
    }

    public function transfer()
    {
        return $this->belongsTo('App\Models\Stock\Stock\Transfer');
    }
}
