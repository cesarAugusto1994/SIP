<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Ticket as TicketModel;

use App\Notifications\NewTicket as TicketNotification;
use Notification;

class Ticket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ticketModel;

    private $users;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TicketModel $ticketModel, $users)
    {
        $this->ticketModel = $ticketModel;
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

          Notification::send($this->users, new TicketNotification($this->ticketModel));

        } catch(\Exception $exception) {
            throw $exception;
        }
    }
}
