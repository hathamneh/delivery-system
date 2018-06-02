<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use League\Flysystem\Config;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * @property mixed package_weight
 * @property mixed base_weight_of_zone
 * @property mixed charge_per_unit_of_zone
 * @property mixed extra_fees_per_unit_of_zone
 */
class Shipment extends Model
{
    use RevisionableTrait, SoftDeletes;

    const STATUS = [
         "picked_up" => 1,
         "received" => 2,
         "attempted_delivery" => 3,
         "cancelled" => 4,
         "rejected" => 5,
         "failed" => 6,
         "delivered" => 7,
         "returned" => 8,
    ];

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 75; // Stop tracking revisions after 75 changes have been made.

    protected $dates = ['deleted_at', 'delivery_date'];

    protected $fillable = [
        'client_account_number',
        'waybill',
        'delivery_date',
        'address_sub_text',
        'address_maps_link',
        'consignee_name',
        'phone_number',
        'package_weight',
        'service_type',
        'internal_notes',
        'external_notes',
        'delivery_cost_lodger',
        'shipment_value',
        'status',
        'price_of_address',
        'base_weight_of_zone',
        'charge_per_unit_of_zone',
        'extra_fees_per_unit_of_zone',
        'actual_paid_by_consignee',
        'courier_cashed',
        'client_paid',
    ];

    public function pickups()
    {
        return $this->belongsToMany(Pickup::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_account_number');
    }

    public function couriers()
    {
        return $this->belongsTo(Courier::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot('price');
    }

    public function extraFees()
    {
        if ($this->package_weight > $this->base_weight_of_zone) {
            $extra_weight = $this->package_weight - $this->base_weight_of_zone;
            $units = ceil($extra_weight / $this->charge_per_unit_of_zone);
            return $units * $this->extra_fees_per_unit_of_zone;
        }
        return 0;
    }

    public function scopeUnpaid($query)
    {
        $statuses = [
            self::STATUS['delivered'],
            self::STATUS['rejected'],
            self::STATUS['returned'],
        ];
        return $query->whereIn('status', $statuses)->where('client_paid', false);
    }

    public function scopePending($query)
    {
        $statuses = [
            self::STATUS['received'],
            self::STATUS['attempted_delivery'],
        ];
        return $query->whereIn('status', $statuses)->upcoming();
    }

    public function scopeCourierDashboard($query)
    {
        $todayDate = Carbon::now()->toDateString();
        $statuses = [
            self::STATUS['received'],
            self::STATUS['delivered'],
            self::STATUS['cancelled'],
            self::STATUS['returned'],
        ];
        return $query->whereIn('status', $statuses)
            ->whereDate('delivery_date', '=', $todayDate);
    }

    public function scopeReceived($query)
    {
        $statuses = [
            self::STATUS['received'],
        ];
        return $query->whereIn('status', $statuses);
    }

    public function scopeDelivered($query)
    {
        $statuses = [
            self::STATUS['delivered'],
        ];
        return $query->whereIn('status', $statuses);
    }

    public function scopeUpcoming($query)
    {
        $todayDate = Carbon::now()->toDateString();
        return $query->whereDate('delivery_date', '>=', $todayDate);
    }
}
