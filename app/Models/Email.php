<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;

class Email extends Model
{
    use Uuids;

    protected $table = 'emails';

    protected $fillable = [
      'user_id', 'message_id', 'message_no', 'subject', 'references', 'date', 'in_reply_to', 'msglist', 'uid',
      'msgn', 'folder_path', 'fetch_options', 'fetch_body', 'fetch_attachment', 'fetch_flags', 'priority',
      'header', 'header_info', 'raw_body', 'text', 'html', 'flag_recent', 'flag_flagged', 'flag_answered', 'flag_deleted',
      'flag_seen', 'flag_draft', 'folder_id'
    ];

    protected $dates = ['date'];

    public function attachments()
    {
       return $this->hasmAny('App\Models\Email\Attachment');
    }

    public function from()
    {
       return $this->hasmAny('App\Models\Email\From');
    }

    public function to()
    {
       return $this->hasmAny('App\Models\Email\To');
    }

    public function cc()
    {
       return $this->hasmAny('App\Models\Email\Cc');
    }

    public function bcc()
    {
       return $this->hasmAny('App\Models\Email\Bcc');
    }
}
