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
 * @property int id
 * @property string type
 * @property float package_weight
 * @property integer pieces
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
 * @property double base_charge
 * @property double actual_paid_by_consignee
 * @property string internal_notes
 * @property string status_notes
 * @property double total_price)
 * @property mixed client_paid
 * @method static self statusIn(array $statuses)
 * @method static self statusIs(string $status)
 * @method static self lodger(string $lodger)
 * @method static self unpaid()
 * @mixin Builder
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
        'pieces',
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
            if ($results[$i]->type == "guest") {
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
        return $this->belongsToMany(Service::class, 'service_shipment', 'shipment_id', 'service_id')->withPivot('price');
    }

    public function returnedIn()
    {
        return $this->hasOne(ReturnedShipment::class, "returned_from", "shipment_id");
    }

    public function scopeType(Builder $query, array $type)
    {
        return $query->whereIn('type', $type);
    }

    public function scopeLodger(Builder $query, $lodger)
    {
        return $query->where('delivery_cost_lodger', $lodger);
    }

    public function scopeFiltered(Builder $builder)
    {
        $results = $builder->get();
        for ($i = 0; $i < $results->count(); $i++) {
            if ($results[$i]->type == "guest") {
                $results[$i] = GuestShipment::find($results[$i]->id);
            }
        }
        return $results;
    }

    public function scopeUnpaid($query)
    {
        //$statuses = Status::where('unpaid', true)->pluck('id');
        return $query->where('client_paid', false);
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
        $status_id = Status::where('name', $status)->value('id');
        return $query->where('status_id', $status_id);
    }

    public function scopeStatusIn(Builder $query, array $statuses)
    {
        $status_ids = Status::whereIn('name', $statuses)->pluck('id');
        return $query->whereIn('status_id', $status_ids);
    }

    public function scopeUpcoming(Builder $query)
    {
        $todayDate = Carbon::now()->toDateString();
        return $query->whereDate('delivery_date', '>=', $todayDate);
    }

    public function scopeWaybill(Builder $query, $waybill)
    {
        return $query->where("waybill", $waybill);
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

    public function getBaseChargeAttribute()
    {
        if (!is_null($this->total_price)) return $this->total_price;
        return $this->price_of_address;
    }

    public function getDeliveryCostAttribute()
    {
        if (!is_null($this->total_price)) return $this->total_price;
        return $this->price_of_address + $this->extra_fees + $this->services_cost;
    }

    public function getTotalAttribute()
    {
        return $this->delivery_cost + $this->shipment_value;
    }


    public function attachServices($services)
    {
        $syncData = [];
        logger($services);
        foreach ($services as $service) {
            if (!$service instanceof Service) $service = Service::findOrFail($service);
            $syncData[$service->id] = ['price' => $service->price];
        }
        logger($syncData);
        return $this->services()->sync($syncData);
    }

    public function scopeSearch(Builder $query, string $term)
    {
        $statuses = Status::where("name", "like", "%$term%")->pluck('id');
        $couriers = Courier::where("name", "like", "%$term%")->pluck('id');
        $addresses = Address::where("name", "like", "%$term%")->pluck('id');
        return $query->whereIn("status_id", $statuses)
            ->orWhere("waybill", "like", "%$term%")
            ->whereIn("courier_id", $couriers, "or")
            ->whereIn("address_id", $addresses, "or")
            ->orWhere("phone_number", "like", "%$term%")
            ->orWhere("shipment_value", "like", "%$term%")
            ->orWhere("actual_paid_by_consignee", "like", "%$term%");
    }

    public function isPriceOverridden()
    {
        return $this->total_price !== null;
    }

    public function isEditable()
    {
        return !$this->status()->whereIn('name', ['delivered', 'returned'])->exists();
    }

    public function toggleClientPaid()
    {
        $this->client_paid = !$this->client_paid;
        return $this;
    }
}
