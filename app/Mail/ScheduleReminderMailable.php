<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScheduleReminderMailable extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    protected $data;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\User $user = NULL, $data = NULL)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name')->with([
            'user' => $this->user,
            'data' => $this->data
        ]);
    }
}
