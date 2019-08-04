<?php

namespace App\Models\Email;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Attachment extends Model
{
    use Uuids;

    protected $table = 'email_attachments';

    protected $fillable = [
      'email_id', 'id', 'name', 'content',
      'type', 'content_type', 'part_number', 'disposition', 'img_src',
    ];

    public function email()
    {
       return $this->belongsTo('App\Models\Email');
    }
}
