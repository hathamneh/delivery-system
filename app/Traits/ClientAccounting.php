<?php
/**
 * Created by PhpStorm.
 * User: haitham
 * Date: 11/08/18
 * Time: 08:47 م
 */

namespace App\Traits;


trait ClientAccounting
{
    public function dueTo()
    {

    }

    public function dueFor()
    {
        $sum = 0;
        $sum += $this->shipments()->statusIs("delivered")->sum('shipment_value');

        return $sum;
    }
}