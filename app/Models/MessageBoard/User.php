<?php

namespace App\Models\MessageBoard;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class User extends Model
{
    use Uuids;

    protected $table = 'meassage_board_users';

    protected $fillable = ['user_id', 'board_id', 'status'];
    protected static $logAttributes = ['user_id', 'board_id', 'status'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function board()
    {
        return $this->belongsTo('App\Models\MessageBoard', 'board_id');
    }
}
