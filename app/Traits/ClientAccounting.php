<?php
/**
 * Created by PhpStorm.
 * User: haitham
 * Date: 11/08/18
 * Time: 08:47 م
 */

namespace App\Traits;


use App\Client;
use App\ClientLimit;
use App\Guest;
use App\Invoice;
use App\Pickup;
use App\Shipment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait ClientAccounting
{

    /**
     * @var Shipment|Builder
     */
    protected $targetShipments = null;

    /**
     * @var Pickup|Builder
     */
    protected $targetPickups = null;

    /**
     * @param Invoice|array $input
     * @return float
     */
    public function dueFrom($input)
    {
        $sum = 0;

        // prepare the shipments we want to work with, exit if no valid shipments
        if (is_null($this->targetShipments) && !($this->targetShipments = $this->prepareTargetShipments($input))) return false;

        // ( DONE ) shipments
        /** @var Shipment $shipments */
        $shipments = clone $this->targetShipments;
        $shipments = $shipments->statusGroups(['delivered'])->lodger('client')->get();
        foreach ($shipments as $shipment) {
            /** @var  Shipment $shipment */
            $sum += $shipment->delivery_cost;
        }

        // ( CONFLICT ) shipments
        $shipments = clone $this->targetShipments;
        $shipments = $shipments->statusIn(['rejected', 'cancelled'])->lodger('client')->get();
        $charged   = [];
        foreach (['rejected', 'cancelled', 'returned'] as $item) {
            $isChargedFor = $this->isChargedFor($item);
            if ($this instanceof Client && !is_null($isChargedFor) && $isChargedFor)
                $charged[$item] = $this->chargedFor()->byStatus($item)->first();
            else
                $charged[$item] = false;
        }
        foreach ($shipments as $shipment) {
            /** @var  Shipment $shipment */
            $status = $shipment->status->name;
            if ($charged[$status]) {
                $sum += $charged[$status]->compute($shipment->delivery_cost);
            }
        }

        return $sum;
    }

    /**
     * @param Invoice|array $input
     * @return float
     */
    public function dueFor($input)
    {
        $sum = 0;

        // prepare the shipments we want to work with, exit if no valid shipments
        if (is_null($this->targetShipments) && !($this->targetShipments = $this->prepareTargetShipments($input))) return false;

        $sum += $this->targetShipments->statusIs("delivered")->orWhere(function (Builder $query) {
            return $query->statusIn(["rejected", "cancelled"])->lodger('client');
        })->sum('actual_paid_by_consignee');

        return $sum;
    }

    public function payment($input)
    {
        $sum = 0;

        // prepare the pickups we want to work with, exit if no valid pickups
        if (!($targetPickups = $this->prepareTargetPickups($input))) return false;

        // Prepaid credit for Not registered clients
        if ($this instanceof Guest)
            $sum += $targetPickups->sum('prepaid_cash');

        return $sum;
    }

    public function extraTermsApplied($input)
    {
        $minimumDeliveryCostCheck      = $this->minimumDeliveryCostCheck($input) ?? 0;
        $maximumReturnedShipmentsCheck = $this->maximumReturnedShipmentsCheck($input) ?? 0;
        return $minimumDeliveryCostCheck + $maximumReturnedShipmentsCheck;
    }

    public function pickupCashCollected($input)
    {
        if (is_null($this->targetPickups) && !($this->targetPickups = $this->prepareTargetPickups($input))) return false;

        return $this->targetPickups->count('prepaid_cash');
    }

    /**
     * @param Invoice|array $input
     * @return float
     */
    public function minimumDeliveryCostCheck($input)
    {
        if (!now()->isLastOfMonth()) return false;
        if (is_null($this->targetShipments) && !($this->targetShipments = $this->prepareTargetShipments($input))) return false;

        /** @var ClientLimit $limit */
        $limit = $this->limits()->where('name', 'min_delivery_cost')->first();
        if ($limit->value == 0) return false;

        $shipments                = $this->targetShipments->whereDate('created_at', '>=', now()->startOfMonth())->get();
        $totals                   = ['delivered' => 0, 'cancelled' => 0, 'rejected' => 0];
        $counts                   = ['delivered' => 0, 'cancelled' => 0, 'rejected' => 0];
        $totalDeliveryCostInMonth = $shipments->reduce(function ($total, Shipment $current) use ($counts, $totals) {
            if ($current->isStatusGroup('delivered')) {
                $counts['delivered']++;
                $totals['delivered'] += $current->delivery_cost;
            } elseif ($current->isStatus('cancelled')) {
                $counts['cancelled']++;
                $totals['cancelled'] += $current->delivery_cost;
            } elseif ($current->isStatus('rejected')) {
                $counts['rejected']++;
                $totals['rejected'] += $current->delivery_cost;
            }
            return $total + $current->delivery_cost;
        }, 0);

        $sum = 0;
        if ($totalDeliveryCostInMonth < $limit->value) {
            if (in_array('delivered', $limit->appliedOn)) {
                $sum += $limit->type === "percentage" ? $totals['delivered'] * ($limit->penalty / 100) : $counts['delivered'] * $limit->penalty;
            }
            if (in_array('cancelled', $limit->appliedOn)) {
                $sum += $limit->type === "percentage" ? $totals['cancelled'] * ($limit->penalty / 100) : $counts['cancelled'] * $limit->penalty;
            }
            if (in_array('rejected', $limit->appliedOn)) {
                $sum += $limit->type === "percentage" ? $totals['rejected'] * ($limit->penalty / 100) : $counts['rejected'] * $limit->penalty;
            }
        }
        return $sum;
    }

    public function maximumReturnedShipmentsCheck($input)
    {
        if (!now()->isLastOfMonth()) return false;
        if (is_null($this->targetShipments) && !($this->targetShipments = $this->prepareTargetShipments($input))) return false;

        /** @var ClientLimit $limit */
        $limit = $this->limits()->where('name', 'max_returned_shipments')->first();
        if ($limit->value == 0) return false;

        $originalShipments = clone $this->targetShipments;
        $returnedShipments = $this->targetShipments->whereNotNull('returned_from')
            ->whereDate('created_at', '>=', now()->startOfMonth())->count();
        if ($returnedShipments >= $limit->value) {
            $count = $originalShipments->whereIn($limit->appliedOn)->count();
            return $count * $limit->penalty;
        }

        return false;
    }


}