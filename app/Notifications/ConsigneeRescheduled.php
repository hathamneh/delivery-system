<?php

namespace App\Notifications;

use App\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ConsigneeRescheduled extends Notification
{
    use Queueable;

    /**
     * @var Shipment
     */
    protected $shipment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->subject("The consignee has rescheduled receiving the shipment - Kangaroo Delivery")
            ->cc($this->shipment->client->secondary_emails)
            ->markdown('notifications.mail', [
                'tmpl'     => 'consignee-rescheduled',
                'client'   => $notifiable,
                'shipment' => $this->shipment
            ]);
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
            //
        ];
    }
}
