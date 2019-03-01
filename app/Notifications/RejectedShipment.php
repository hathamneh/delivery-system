<?php

namespace App\Notifications;

use App\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RejectedShipment extends Notification
{
    use Queueable;

    /**
     * @var Shipment
     */
    protected $shipment;

    /**
     * Create a new notification instance.
     *
     * @param Shipment $shipment
     */
    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = new MailMessage;
        $message
            ->subject("Rejected Shipment - Kangaroo Delivery")
            ->cc($this->shipment->client->secondary_emails)
            ->markdown('notifications.mail', [
                'tmpl'     => 'rejected-shipment',
                'client'   => $notifiable,
                'shipment' => $this->shipment
            ]);
        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
