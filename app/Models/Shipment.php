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

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 75; // Stop tracking revisions after 75 changes have been made.

    protected $dates = ['deleted_at', 'delivery_date'];

    protected $fillable = [
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
        'status_notes',
        'price_of_address',
        'base_weight_of_zone',
        'charge_per_unit_of_zone',
        'extra_fees_per_unit_of_zone',
        'actual_paid_by_consignee',
        'courier_cashed',
        'client_paid',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function subStatus()
    {
        return $this->belongsTo(SubStatus::class);
    }

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
        $statuses = Status::where('unpaid', true)->pluck('id');
        return $query->whereIn('status_id', $statuses)->where('client_paid', false);
    }

    public function scopePending($query)
    {
        $statuses = Status::where('pending', true)->pluck('id');
        return $query->whereIn('status_id', $statuses)->upcoming();
    }

    public function scopeCourierDashboard($query)
    {
        $todayDate = Carbon::now()->toDateString();
        $statuses = Status::where('courier_dashboard', true)->pluck('id');
        return $query->whereIn('status_id', $statuses)
            ->whereDate('delivery_date', '=', $todayDate);
    }

    public function scopeStatusIs($query, $status)
    {
        $statuse_id = Status::where('name', $status)->value('id');
        return $query->where('status_id', $statuse_id);
    }

    public function scopeUpcoming($query)
    {
        $todayDate = Carbon::now()->toDateString();
        return $query->whereDate('delivery_date', '>=', $todayDate);
    }
}
