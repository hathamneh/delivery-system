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
use App\Shipment;
use Carbon\Carbon;

trait ClientAccounting
{

    protected $targetShipments = null;

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
        $shipments = clone $this->targetShipments;
        $shipments = $shipments->statusIn(['delivered', 'returned'])->lodger('client')->get();
        foreach ($shipments as $shipment) {
            /** @var  Shipment $shipment */
            $sum += $shipment->delivery_cost;
        }

        // ( CONFLICT ) shipments
        $shipments = clone $this->targetShipments;
        $shipments = $shipments->statusIn(['rejected', 'cancelled'])->lodger('client')->get();
        $charged = [];
        foreach (['rejected', 'cancelled'] as $item) {
            if ($this instanceof Client && $this->isChargedFor($item))
                $charged[$item] = $this->chargedFor()->byStatus($item)->first();
            else
                $charged[$item] = false;
        }
        foreach ($shipments as $shipment) {
            /** @var  Shipment $shipment */
            $status = $shipment->status->name;
            if ($charged[$status]) {
                $sum += abs($shipment->actual_paid_by_consignee - $charged[$status]->compute($shipment->delivery_cost));
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

        // Actual paid by consignee for delivered shipments
        $sum += $this->targetShipments->statusIs("delivered")->sum('actual_paid_by_consignee');

        // Actual paid by consignee fro conflicts only if the lodger is the client
        $sum += $this->targetShipments->statusIn(["rejected", "returned"])->lodger('client')->sum('actual_paid_by_consignee');
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
        $minimumDeliveryCostCheck = $this->minimumDeliveryCostCheck($input) ?? 0;
        $maximumReturnedShipmentsCheck = $this->maximumReturnedShipmentsCheck($input) ?? 0;
        return $minimumDeliveryCostCheck + $maximumReturnedShipmentsCheck;
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

        $shipments = $this->targetShipments->whereDate('created_at', '>=', now()->startOfMonth())->get();
        $counts = ['delivered' => 0, 'cancelled' => 0, 'rejected' => 0];
        $totalDeliveryCostInMonth = $shipments->reduce(function ($total, Shipment $current) use ($counts) {
            if ($current->isStatus('delivered')) $counts['delivered']++;
            elseif ($current->isStatus('cancelled')) $counts['cancelled']++;
            elseif ($current->isStatus('rejected')) $counts['rejected']++;
            return $total + $current->delivery_cost;
        }, 0);

        $sum = 0;
        if ($totalDeliveryCostInMonth < $limit->value) {
            if (in_array('delivered', $limit->appliedOn)) $sum += $counts['delivered'] * $limit->penalty;
            if (in_array('cancelled', $limit->appliedOn)) $sum += $counts['cancelled'] * $limit->penalty;
            if (in_array('rejected', $limit->appliedOn)) $sum += $counts['rejected'] * $limit->penalty;
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