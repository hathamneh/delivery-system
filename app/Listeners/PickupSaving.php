<?php

namespace App\Listeners;

use App\Pickup;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\PickupSaving as PickupSavingEvent;

class PickupSaving
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
     * @param PickupSavingEvent $event
     * @return void
     */
    public function handle(PickupSavingEvent $event)
    {
        $pickup = $event->pickup;
        if(is_null($pickup->identifier))
            $pickup->generateIdentifier();
    }
}
