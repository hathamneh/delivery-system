<?php
/**
 * Created by PhpStorm.
 * User: haitham
 * Date: 10/10/18
 * Time: 11:40 م
 */

namespace App\Traits;


use App\Invoice;

trait PrepareAccounting
{


    /**
     * @param Invoice|array $input
     * @return Shipment|bool
     */
    public function prepareTargetShipments($input)
    {
        if ($input instanceof Invoice)
            return $input->shipments();
        elseif (is_array($input) && count($input) == 2) {
            $start = $input[0];
            $end = $input[1];
            return $this->shipments()->whereBetween('created_at', [$start, $end]);
        } else {
            return false;
        }
    }


    /**
     * @param Invoice|array $input
     * @return Shipment|bool
     */
    public function prepareTargetPickups($input)
    {
        if ($input instanceof Invoice)
            return $input->pickups();
        elseif (is_array($input) && count($input) == 2) {
            $start = $input[0];
            $end = $input[1];
            return $this->pickups()->whereBetween('created_at', [$start, $end]);
        } else {
            return false;
        }
    }

}