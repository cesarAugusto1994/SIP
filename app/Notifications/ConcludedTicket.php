<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Ticket;

class ConcludedTicket extends Notification
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
        return ['database'];
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
                    ->greeting('Chamado Concluído')
                    ->subject('Chamado Concluído: ' . $this->ticket->type->category->name . ' > ' . $this->ticket->type->name)
                    ->line('Um chamado aberto por você foi concluído. Agora verifique se a sua solicitação foi atendida como esperado, caso sim finalize o seu chamado.')
                    ->line(' >> Informações do Chamado << ')
                    ->line('Assunto: ' . $this->ticket->type->category->name . ' - ' . $this->ticket->type->name)
                    ->line('Descrição: ' . $this->ticket->description)
                    ->line('Solicitante: ' . $this->ticket->user->person->name)
                    ->line('Data: ' . $this->ticket->created_at->format('d/m/Y H:i'))
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
          'message' => 'Seu chamado foi concluído. Agora verifique se a sua solicitação foi atendida como esperado, caso sim finalize o seu chamado.',
          'date' => $this->ticket->created_at,
        ];
    }
}
