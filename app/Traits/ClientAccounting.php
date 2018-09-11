<?php
/**
 * Created by PhpStorm.
 * User: haitham
 * Date: 11/08/18
 * Time: 08:47 م
 */

namespace App\Traits;


use App\ClientChargedFor;
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
        if(!($targetShipments = $this->prepareTargetShipments($input))) return false;

        // ( DONE ) shipments
        $shipments = $targetShipments->statusIn(['delivered', 'returned'])->lodger('client')->get();
        foreach ($shipments as $shipment) {
            /** @var  Shipment $shipment */
            $sum += $shipment->delivery_cost;
        }

        // ( CONFLICT ) shipments
        foreach (['rejected', 'cancelled'] as $item) {
            if ($this->isChargedFor($item)) {
                /** @var ClientChargedFor $cf */
                $cf = ClientChargedFor::byStatus($item)->first();
                $shipments = $targetShipments->statusIs($item)->lodger('client')->get();
                foreach ($shipments as $shipment) {
                    /** @var  Shipment $shipment */
                    $sum += $cf->compute($shipment->delivery_cost);
                }
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
        if(!($targetShipments = $this->prepareTargetShipments($input))) return false;

        // Actual paid by consignee for delivered shipments
        $sum += $targetShipments->statusIs("delivered")->sum('actual_paid_by_consignee');

        // Actual paid by consignee fro conflicts only if the lodger is the client
        $sum += $targetShipments->statusIn(["rejected", "returned"])->lodger('client')->sum('actual_paid_by_consignee');
        return $sum;
    }

    /**
     * @param Invoice|array $input
     * @return Shipment|bool
     */
    public function prepareTargetShipments($input)
    {
        if($input instanceof Invoice)
            return $input->shipments();
        elseif(is_array($input) && count($input) == 2) {
            $start = $input[0];
            $end = $input[1];
            return $this->shipments()->whereBetween('created_at', [$start, $end]);
        }
        else {
            return false;
        }
    }
}