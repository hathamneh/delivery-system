<?php

namespace App\Listeners;

use App\Pickup;
use App\PickupStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\PickupSaving as PickupSavingEvent;

class PickupSaving
{

    /** @var Pickup */
    private $pickup;

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
        $this->pickup = $event->pickup;
        if(is_null($this->pickup->identifier))
            $this->pickup->generateIdentifier();

        if ($this->pickup->isDirty("pickup_status_id")) {
            $this->logStatusChanged();
        }
    }

    public function logStatusChanged()
    {
        $original = PickupStatus::find($this->pickup->getOriginal('pickup_status_id'));
        $new = PickupStatus::find($this->pickup->pickup_status_id);
        if(is_null($new)) return;
        $activityItem = activity()
            ->performedOn($this->pickup)
            ->causedBy(auth()->user());
        switch ($new->name) {
            case "ready":
                $activityItem->log('Pickup is ready');
                break;
            case "rescheduled":
                $activityItem->log('Pick up time has been rescheduled to ' . $this->pickup->available_time);
                break;
            case "pass_to_office":
                $activityItem->log('Client will pass the pickup to the office');
                break;
            case "rejected":
                $activityItem->log('Pickup has been rejected');
                break;
            case "cancelled":
                $activityItem->log('Pickup has been cancelled');
                break;
            case "not_available":
                $activityItem->log('Client is not available to pick up');
                break;
            case "failed":
                $activityItem->log('Pick up has failed');
                break;
            case "on_hold":
                $activityItem->log('Pickup is on hold');
                break;
            case "collected":
                $activityItem->log('Pickup has been collected');
                break;
        }
    }
}
