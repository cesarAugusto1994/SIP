<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Ticket;

class FinishedTicket extends Notification
{
    use Queueable;

    private $ticket;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Chamado Finalizado')
                    ->subject('Chamado Finalizado: ' . $this->ticket->type->category->name . ': ' . $this->ticket->type->name)
                    ->line('O chamado #' . $this->ticket->id . ' foi finalizado com sucesso por ' . $this->ticket->user->person->name . ' em ' . $this->ticket->created_at->format('d/m/Y H:i') . '.')
                    ->action('Acessar Chamado', route('tickets.show', $this->ticket->uuid))
                    ->salutation('Esta é uma mensagem automática, favor não responder.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
          'message' => $this->ticket->user->person->name . ' finalizou o chamado ' . $this->ticket->id,
          'date' => $this->ticket->created_at,
          'url' => route('notifications.index')
        ];
    }
}
