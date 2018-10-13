<?php
/**
 * Created by PhpStorm.
 * User: haitham
 * Date: 11/08/18
 * Time: 08:47 م
 */

namespace App\Traits;


use App\Client;
use App\Guest;
use App\Invoice;
use App\Shipment;

trait ClientAccounting
{
    /**
     * @param Invoice|array $input
     * @return float
     */
    public function dueFrom($input)
    {
        $sum = 0;

        // prepare the shipments we want to work with, exit if no valid shipments
        if (!($targetShipments = $this->prepareTargetShipments($input))) return false;

        // ( DONE ) shipments

        $shipments = clone $targetShipments;
        $shipments = $shipments->statusIn(['delivered', 'returned'])->lodger('client')->get();
        foreach ($shipments as $shipment) {
            /** @var  Shipment $shipment */
            $sum += $shipment->delivery_cost;
        }

        // ( CONFLICT ) shipments
        $shipments = clone $targetShipments;
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
        if (!($targetShipments = $this->prepareTargetShipments($input))) return false;

        // Actual paid by consignee for delivered shipments
        $sum += $targetShipments->statusIs("delivered")->sum('actual_paid_by_consignee');

        // Actual paid by consignee fro conflicts only if the lodger is the client
        $sum += $targetShipments->statusIn(["rejected", "returned"])->lodger('client')->sum('actual_paid_by_consignee');
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

}