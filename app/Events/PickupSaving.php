<?php

namespace App\Events;

use App\Pickup;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PickupSaving
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pickup;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Pickup $pickup)
    {
        $this->pickup = $pickup;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
