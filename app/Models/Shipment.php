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
 * @method static self courierCashed(bool $value)
 * @mixin Builder
 */
class Shipment extends Model
{
    use RevisionableTrait, SoftDeletes, GenerateWaybills;

    /**
     * @var int
     */
    protected $waybill_digits = 8;
    /**
     * @var string
     */
    protected $waybill_prefix = "1";

    /**
     * @var bool
     */
    protected $revisionEnabled = true;
    /**
     * @var bool
     */
    protected $revisionCreationsEnabled = true;
    /**
     * @var array
     */
    protected $revisionFormattedFields = [
        'delivery_date' => "datetime:d-m-Y"
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'delivery_date'];

    /**
     * @var array
     */
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

    /**
     * model life cycle event listeners
     */
    public static function boot(){
        parent::boot();

        static::creating(function ($instance){
            $instance->type = static::$waybill_type ?? "normal";
        });

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', static::$waybill_type ?? "normal");
        });
    }

    /**
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subStatus()
    {
        return $this->belongsTo(SubStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pickups()
    {
        return $this->belongsToMany(Pickup::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_account_number', 'account_number');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function getAddressAttribute()
    {
        $address = $this->address()->first();
        $custom = $address->customFor($this->client);
        if(!is_null($custom))
            return $custom;
        return $address;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_shipment', 'shipment_id', 'service_id')->withPivot('price');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function returnedIn()
    {
        return $this->hasOne(ReturnedShipment::class, "returned_from", "shipment_id");
    }

    /**
     * @param Builder $query
     * @param array $type
     * @return Builder
     */
    public function scopeType(Builder $query, array $type)
    {
        return $query->whereIn('type', $type);
    }

    /**
     * @param Builder $query
     * @param $lodger
     * @return Builder
     */
    public function scopeLodger(Builder $query, $lodger)
    {
        return $query->where('delivery_cost_lodger', $lodger);
    }

    /**
     * @param Builder $builder
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
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

    /**
     * @param $query
     * @return mixed
     */
    public function scopeUnpaid($query)
    {
        //$statuses = Status::where('unpaid', true)->pluck('id');
        return $query->where('client_paid', false);
    }

    /**
     * @param $query
     * @param bool $value
     * @return mixed
     */
    public function scopeCourierCashed($query, $value = true)
    {
        //$statuses = Status::where('unpaid', true)->pluck('id');
        return $query->where('courier_cashed', $value);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePending($query)
    {
        $statuses = Status::where('pending', true)->pluck('id');
        return $query->whereIn('status_id', $statuses)->upcoming();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCourierDashboard($query)
    {
        $todayDate = Carbon::now()->toDateString();
        $statuses = Status::where('courier_dashboard', true)->pluck('id');
        return $query->whereIn('status_id', $statuses)
            ->whereDate('delivery_date', '=', $todayDate);
    }

    /**
     * @param $query
     * @param $status
     * @return mixed
     */
    public function scopeStatusIs($query, $status)
    {
        $status_id = Status::where('name', $status)->value('id');
        return $query->where('status_id', $status_id);
    }

    /**
     * @param Builder $query
     * @param array $statuses
     * @return Builder
     */
    public function scopeStatusIn(Builder $query, array $statuses)
    {
        $status_ids = Status::whereIn('name', $statuses)->pluck('id');
        return $query->whereIn('status_id', $status_ids);
    }

    /**
     * @param Builder $query
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeUpcoming(Builder $query)
    {
        $todayDate = Carbon::now()->toDateString();
        return $query->whereDate('delivery_date', '>=', $todayDate);
    }

    /**
     * @param Builder $query
     * @param $waybill
     * @return Builder
     */
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


    /**
     *
     */
    public function gatherPriceInformation()
    {
        if ($this->service_type == "sameday")
            $this->price_of_address = $this->address->sameday_price;
        else
            $this->price_of_address = $this->address->scheduled_price;

        $zone = $this->address->zone;
        $this->base_weight_of_zone = $zone->base_weight;
        $this->charge_per_unit_of_zone = $zone->charge_per_unit;
        $this->extra_fees_per_unit_of_zone = $zone->extra_fees_per_unit;
    }

    /**
     * @return float|int
     */
    public function getExtraFeesAttribute()
    {
        if ($this->package_weight > $this->base_weight_of_zone) {
            $extra_weight = $this->package_weight - $this->base_weight_of_zone;
            $units = ceil($extra_weight / $this->charge_per_unit_of_zone);
            return $units * $this->extra_fees_per_unit_of_zone;
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getServicesCostAttribute()
    {
        $services_cost = 0;
        foreach ($this->services as $service) {
            $services_cost += $service->price;
        }
        return $services_cost;
    }

    /**
     * @return float
     */
    public function getBaseChargeAttribute()
    {
        if (!is_null($this->total_price)) return $this->total_price;
        return $this->price_of_address;
    }

    /**
     * @return float
     */
    public function getDeliveryCostAttribute()
    {
        if (!is_null($this->total_price)) return $this->total_price;
        return $this->price_of_address + $this->extra_fees + $this->services_cost;
    }

    /**
     * @return float|mixed
     */
    public function getTotalAttribute()
    {
        return $this->delivery_cost + $this->shipment_value;
    }


    /**
     * @param $services
     * @return array
     */
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

    /**
     * @param Builder $query
     * @param string $term
     * @return Builder
     */
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

    /**
     * @return bool
     */
    public function isPriceOverridden()
    {
        return $this->total_price !== null;
    }

    /**
     * @return bool
     */
    public function isEditable()
    {
        return !$this->status()->whereIn('name', ['delivered', 'returned'])->exists();
    }

    /**
     * @return $this
     */
    public function toggleClientPaid()
    {
        $this->client_paid = !$this->client_paid;
        return $this;
    }
}
