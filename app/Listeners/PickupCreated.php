<?php

namespace App\Listeners;

use App\Pickup;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PickupCreated
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\PickupCreated $event
     * @return void
     */
    public function handle(\App\Events\PickupCreated $event)
    {
        /** @var Pickup $pickup */
        $pickup = $event->pickup;
        /** @var User $user */
        $user = auth()->user();
        activity()
            ->performedOn($pickup)
            ->causedBy($user)
            ->log("Pick up created on " . now()->toDayDateTimeString() . " by " . $user->username);
    }
}
