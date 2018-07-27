<?php

namespace App;

use App\Traits\GenerateWaybills;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * @property mixed package_weight
 * @property mixed base_weight_of_zone
 * @property mixed charge_per_unit_of_zone
 * @property mixed extra_fees_per_unit_of_zone
 * @property integer waybill
 * @property Carbon delivery_date
 * @property mixed shipment_value
 * @property string consignee_name
 * @property mixed phone_number
 * @property mixed address_sub_text
 * @property mixed address_maps_link
 * @property mixed service_type
 * @property mixed delivery_cost_lodger
 * @property Client client
 * @property bool is_guest
 * @property Guest guest
 * @property double price_of_address
 * @property Address address
 * @property Courier courier
 * @property Status status
 * @property int client_account_number
 * @property Collection services
 * @property double extra_fees
 * @property double services_cost
 * @property double delivery_cost
 * @property double actual_paid_by_consignee
 * @property string internal_notes
 * @property string status_notes
 */
class Shipment extends Model
{
    use RevisionableTrait, SoftDeletes, GenerateWaybills;

    protected $waybill_digits = 8;
    protected $waybill_prefix = "3";

    protected $revisionEnabled = true;
    protected $revisionCreationsEnabled = true;
    protected $revisionFormattedFields = [
        'delivery_date' => "datetime:d-m-Y"
    ];

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

    public static function all($columns = ['*'])
    {
        $results = parent::all($columns);
        for ($i = 0; $i < $results->count(); $i++) {
            if($results[$i]->type == "guest") {
                $results[$i] = GuestShipment::find($results[$i]->id);
            }
        }
        return $results;
    }

    /**
     * model life cycle event listeners
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($instance) {
            $instance->type = "normal";
        });

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->whereIn('type', ['normal', 'guest']);
        });

    }


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
        return $this->belongsTo(Client::class, 'client_account_number', 'account_number');
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_shipment', 'service_id', 'shipment_id')->withPivot('price');
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


    /**
     * @param array $clientData
     * @throws \Exception
     */
    public function saveClient(array $clientData)
    {
        $this->client()->associate(Client::findOrFail($clientData['account_number']));
    }


    public function gatherPriceInformation()
    {
        $accountNumber = $this->client->account_number ?? 0;
        if ($this->service_type == "sameday")
            $this->price_of_address = $this->address->sameDayPriceFor($accountNumber);
        else
            $this->price_of_address = $this->address->scheduledPriceFor($accountNumber);

        $zone = $this->address->zone;
        $this->base_weight_of_zone = $zone->extraFeesPerUnitFor($accountNumber);
        $this->charge_per_unit_of_zone = $zone->chargePerUnitFor($accountNumber);
        $this->extra_fees_per_unit_of_zone = $zone->extraFeesPerUnitFor($accountNumber);
    }

    public function getExtraFeesAttribute()
    {
        if ($this->package_weight > $this->base_weight_of_zone) {
            $extra_weight = $this->package_weight - $this->base_weight_of_zone;
            $units = ceil($extra_weight / $this->charge_per_unit_of_zone);
            return $units * $this->extra_fees_per_unit_of_zone;
        }
        return 0;
    }

    public function getServicesCostAttribute()
    {
        $services_cost = 0;
        foreach ($this->services as $service) {
            $services_cost += $service->price;
        }
        return $services_cost;
    }

    public function getDeliveryCostAttribute()
    {
        return $this->price_of_address + $this->extra_fees + $this->services_cost;
    }

    public function getTotalAttribute()
    {
        return $this->delivery_cost + $this->shipment_value;
    }

}
