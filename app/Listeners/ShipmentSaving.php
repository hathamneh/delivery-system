<?php

namespace App\Listeners;

use App\Address;
use App\Branch;
use App\Courier;
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
        if (is_null($this->shipment->id)) return;
        $dirtyFields = $this->shipment->getDirty();
        foreach ($dirtyFields as $dirtyField => $value) {
            if ($dirtyField === "status_id" || $dirtyField === "status_notes") {
                $this->logStatusChanged();
            } else {

                activity()
                    ->performedOn($this->shipment)
                    ->causedBy(auth()->user())
                    ->log($this->getFieldName($dirtyField) . " has been changed to " . $this->getValue($dirtyField, $value));
            }
        }
    }

    public function logField($field, $value)
    {

        $message = $this->getFieldName($field) . " has been changed to " . $this->getValue($field, $value);
        activity()
            ->performedOn($this->shipment)
            ->causedBy(auth()->user())
            ->log($message);
    }

    public function getFieldName($field)
    {
        switch ($field) {
            case "address_id":
                return trans('zone.address.label');
            case "courier_id":
                return trans('shipment.courier');
            default:
                return trans("shipment.{$field}");
        }
    }

    public function getValue($field, $value)
    {
        switch ($field) {
            case "address_id":
                return Address::find($value)->name;
            case "courier_id":
                return Courier::find($value)->name;
            default:
                if(is_bool($value))
                    return $value ? "true" : "false";
                return $value;
        }
    }

    protected function logStatusChanged()
    {
        $original = Status::find($this->shipment->getOriginal('status_id'));
        $new      = Status::find($this->shipment->status_id);

        // send alert in email to notify this change
        $this->shipment->notifyFor($new);

        if (is_null($new)) return;
        $activityItem = activity()
            ->performedOn($this->shipment)
            ->causedBy(auth()->user());
        $extraNotes   = $this->shipment->status_notes;
        switch ($new->name) {
            case "picked_up":
                $activityItem->log('Shipment picked up');
                break;
            case "received":
                $branch = Branch::find($this->shipment->branch_id)->name ?? "";
                $activityItem->log("Shipment is received to company office in {$branch}" . (!empty($extraNotes) ? ", {$extraNotes}" : ""));
                break;
            case "out_for_delivery":
                $activityItem->log('Shipment is now out for delivery' . (!empty($extraNotes) ? ", {$extraNotes}" : ""));
                break;
            case "not_available":
                $activityItem->log('Attempting delivery but consignee is not available' . (!empty($extraNotes) ? ", {$extraNotes}" : ""));
                break;
            case "cancelled":
                $activityItem->log('Shipment has been cancelled' . (!empty($extraNotes) ? ", {$extraNotes}" : ""));
                break;
            case "rejected":
                $activityItem->log("Shipment has been rejected, consignee has paid {$this->shipment->actual_paid_by_consignee}" . (!empty($extraNotes) ? ", {$extraNotes}" : ""));
                break;
            case "failed":
                $activityItem->log('Failed to deliver the shipment' . (!empty($extraNotes) ? ", {$extraNotes}" : ""));
                break;
            case "rescheduled":
                $activityItem->log('Rescheduled the delivery of the shipment until ' . $this->shipment->delivery_date->toFormattedDateString() . (!empty($extraNotes) ? ", {$extraNotes}" : ""));
                break;
            case "delivered":
                $activityItem->log('Shipment delivered successfully!' . (!empty($extraNotes) ? ", {$extraNotes}" : ""));
                break;
            case "collected_from_office":
                $branch = Branch::find($this->shipment->branch_id)->name ?? "";
                $activityItem->log("Shipment has been collected from {$branch} office by the consignee" . (!empty($extraNotes) ? ", {$extraNotes}" : ""));
                break;
            case "collect_from_office":
                $branch = Branch::find($this->shipment->branch_id)->name ?? "";
                $activityItem->log("To be collected from {$branch} office" . (!empty($extraNotes) ? ", {$extraNotes}" : ""));
                break;
            case "departed":
                $newBranch = Branch::find($this->shipment->branch_id)->name ?? "";
                $activityItem->log("Shipment has been departed to {$newBranch}" . (!empty($extraNotes) ? ", {$extraNotes}" : ""));
                break;
            case "ready":
                $activityItem->log("Shipment is now ready to be delivered" . (!empty($extraNotes) ? ", {$extraNotes}" : ""));
                break;
        }
    }
}
