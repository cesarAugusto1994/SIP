<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class DeliveryOrder extends Notification implements ShouldQueue
{
    use Queueable;

    private $subject;
    private $deliverOrder;
    private $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($deliverOrder, $subject, $message)
    {
        $this->deliverOrder = $deliverOrder;
        $this->subject = $subject;
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
        $orderCode = str_pad($this->deliverOrder->id, 6, "0", STR_PAD_LEFT);
        $address = $this->deliverOrder->address;

        $mailMessage = new MailMessage();

        $mailMessage->greeting('Entrega de Documentos')
                    ->subject($this->subject)
                    ->line('Empresa: ' . $this->deliverOrder->client->name)
                    ->line('Ordem de Entrega No.: ' . $orderCode)
                    ->line('Situação: ' . $this->deliverOrder->status->name)
                    ->line('Endereço: ' . $address->street . ', ' . $address->number . ' - ' . $address->district  . ' - ' .  $address->city . ' / ' . $address->zip)
                    ->line(' > Documentos < ');

        foreach ($this->deliverOrder->documents as $key => $item) {
            $document = $item->document;
            $documentCode = str_pad($document->id, 6, "0", STR_PAD_LEFT);
            $employeeName = $document->employee->name ?? '';
            $mailMessage->line($documentCode . ' - ' . $document->type->name . ' - ' . $employeeName);
        }

        $mailMessage->action('Acompanhar Entrega', route('start_delivery', $this->deliverOrder->uuid))
                    ->salutation('Esta é uma mensagem automática, favor não responder.');

        return $mailMessage;
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
                    ->content('One of your invoices has been paid!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $orderCode = str_pad($this->deliverOrder->id, 6, "0", STR_PAD_LEFT);

        return [
          'message' => 'A entrega de no. ' . $orderCode . ' está a caminho do destino.',
          'date' => $this->deliverOrder->created_at,
          'url' => route('delivery-order.show', $this->deliverOrder->uuid)
        ];
    }
}
