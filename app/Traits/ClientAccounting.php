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
     * @param Invoice $invoice
     * @return float
     */
    public function dueFrom(Invoice $invoice): float
    {
        $sum = 0;

        $shipments = $invoice->shipments()->statusIn(['delivered', 'returned'])->lodger('client')->get();
        foreach ($shipments as $shipment) {
            /** @var  Shipment $shipment */
            $sum += $shipment->delivery_cost;
        }

        foreach (['rejected', 'cancelled'] as $item) {
            if ($this->isChargedFor($item)) {
                /** @var ClientChargedFor $cf */
                $cf = ClientChargedFor::byStatus($item)->first();
                $shipments = $invoice->shipments()->statusIs($item)->lodger('client')->get();
                foreach ($shipments as $shipment) {
                    /** @var  Shipment $shipment */
                    $sum += $cf->compute($shipment->delivery_cost);
                }
            }
        }
        return $sum;
    }

    /**
     * @param Invoice $invoice
     * @return float
     */
    public function dueFor(Invoice $invoice): float
    {
        $sum = 0;
        $sum += $invoice->shipments()->statusIs("delivered")->sum('actual_paid_by_consignee');
        $sum += $invoice->shipments()->statusIn(["rejected", "returned"])->lodger('client')->sum('actual_paid_by_consignee');
        return $sum;
    }
}