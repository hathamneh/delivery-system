<?php

namespace App\Listeners;

use App\Branch;
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
            case "picked_up":
                $activityItem->log('Shipment picked up');
                break;
            case "received":
                $activityItem->log('Shipment is received to company office');
                break;
            case "out_for_delivery":
                $activityItem->log('Shipment is now out for delivery');
                break;
            case "not_available":
                $activityItem->log('Attempting delivery but consignee is not available');
                break;
            case "cancelled":
                $activityItem->log('Shipment has been cancelled');
                break;
            case "rejected":
                $activityItem->log('Shipment has been rejected');
                break;
            case "failed":
                $activityItem->log('Failed to deliver the shipment');
                break;
            case "rescheduled":
                $activityItem->log('Rescheduled the delivery of the shipment until ' . $this->shipment->delivery_date->toFormattedDateString());
                break;
            case "delivered":
                $activityItem->log('Shipment delivered successfully!');
                break;
            case "collected_from_office":
                $branch = Branch::find($this->shipment->branch_id)->name ?? "";
                $activityItem->log("Shipment has been collected from {$branch} office by the consignee");
                break;
            case "collect_from_office":
                $branch = Branch::find($this->shipment->branch_id)->name ?? "";
                $activityItem->log("To be collected from {$branch} office");
                break;
            case "departed":
                $newBranch = Branch::find($this->shipment->branch_id)->name ?? "";
                $activityItem->log("Shipment has been departed to {$newBranch}");
                break;
            case "ready":
                $activityItem->log("Shipment is now ready to be delivered");
                break;
        }
    }
}
