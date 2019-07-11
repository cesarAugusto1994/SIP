<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\MessageBoard;

class NewMessage extends Notification
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MessageBoard $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
                    ->greeting('Novo Recado')
                    ->subject('Recado: ' . $this->message->subject)
                    ->line($this->message->user->person->name . ' adicionou um novo recado no Mural de Recados')
                    ->line('Assunto: ' . $this->message->subject)
                    ->action('Acessar', route('message-board.index'))
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
          'message' => $this->message->user->person->name . ' adicionou um novo recado no Mural de Recados',
          'date' => $this->message->created_at,
        ];
    }
}
