<?php

namespace App\Listeners;

use App\ReturnedShipment;
use App\Shipment;
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
        if($event->shipment instanceof ReturnedShipment)
            $shipment = Shipment::find($event->shipment->id);
        else
            $shipment = $event->shipment;
        activity()
            ->performedOn($shipment)
            ->causedBy(auth()->user())
            ->log('Shipment has been created');
    }
}
