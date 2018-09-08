<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PrepaidShipment extends Shipment
{

    protected $table = "shipments";
    protected $waybill_prefix = "2";
    protected static $waybill_type = "prepaid";

}
