<?php

namespace App\Listeners;

use App\Shipment;
use App\Status;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\ShipmentSaving as ShipmentSavingEvent;

class ShipmentSaving
{

    /**
     * @var Shipment
     */
    protected $shipment;

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param ShipmentSavingEvent $event
     * @return void
     */
    public function handle(ShipmentSavingEvent $event)
    {
        $this->shipment = $event->shipment;
        if ($this->shipment->isDirty("status_id")) {
            $this->logStatusChanged();
        }
    }

    protected function logStatusChanged()
    {
        $original = Status::find($this->shipment->getOriginal('status_id'));
        $new = Status::find($this->shipment->status_id);
        $activityItem = activity()
            ->performedOn($this->shipment)
            ->causedBy(auth()->user());
        switch ($new->name) {
            case "consignee_rescheduled":
                $activityItem->log('Consignee has rescheduled the delivery of the shipment until ' . $this->shipment->delivery_date->toFormattedDateString());
                break;
            case "delivered":
                $activityItem->log('Shipment has been delivered successfully!');
                break;
            default:
                $activityItem->log('Shipment status has been changed from ' .
                    trans("shipment.statuses." . $original->name) . " to " .
                    trans("shipment.statuses." . $new->name));
        }
    }
}
