<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\ShipmentCreated as ShipmentCreatedEvent;

class ShipmentCreated
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
     * @param ShipmentCreatedEvent $event
     * @return void
     */
    public function handle(ShipmentCreatedEvent $event)
    {
        activity()
            ->performedOn($event->shipment)
            ->causedBy(auth()->user())
            ->log('Shipment has been created');
    }
}
