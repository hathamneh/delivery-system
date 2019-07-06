<?php

namespace App\Notifications;

use App\Pickup;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LatePickup extends Notification
{
    use Queueable;

    /**
     * @var Pickup
     */
    public $pickup;

    /**
     * Create a new notification instance.
     *
     * @param Pickup $pickup
     */
    public function __construct(Pickup $pickup)
    {
        $this->pickup = $pickup;
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'pickup_id' => $this->pickup->id,
            'message' => "There's an unsettled pickup!",
            "link" => route('pickups.edit', ['pickup' => $this->pickup, 'noty' => $this->id])
        ];
    }
}
