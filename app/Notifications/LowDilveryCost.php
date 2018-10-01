<?php

namespace App\Notifications;

use App\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LowDilveryCost extends Notification
{
    use Queueable;

    /**
     * @var Client
     */
    protected $client;

    /**
     * Create a new notification instance.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'client_account_number' => $this->client->account_number,
            'message'               => "The client " . $this->client->name . " has low delivery cost this month",
            "link"                  => route('clients.show', ['client' => $this->client, 'tab' => 'statistics', 'noty' => $this->id])
        ];
    }
}
