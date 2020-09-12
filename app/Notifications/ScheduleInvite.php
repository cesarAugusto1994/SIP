<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Schedule;

class ScheduleInvite extends Notification
{
    use Queueable;

    private $schedule;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
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
                    ->greeting('Novo Compromisso')
                    ->subject('Novo compromisso em que você foi marcado.')
                    ->line($this->schedule->user->person->name . ' marcou você em um novo compromisso.')
                    ->line('Titulo: ' . $this->schedule->title)
                    ->line('Tipo: ' . $this->schedule->type->name)
                    ->line('Descrição: ' . $this->schedule->description)
                    ->line('Data: ' . $this->schedule->start->format('d/m/Y H:i') . ' até ' . $this->schedule->end->format('d/m/Y H:i'))
                    ->action('Acessar', route('schedules.show', $this->schedule->uuid));
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
          'message' => $this->schedule->user->person->name . ' marcou você em um novo compromisso.',
          'date' => $this->schedule->created_at,
          'url' => route('schedules.show', $this->schedule->uuid)
        ];
    }
}
