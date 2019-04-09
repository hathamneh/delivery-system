<?php

namespace App;

use App\Http\Controllers\ShipmentFilters;
use App\Notifications\CancelledShipment;
use App\Notifications\ConsigneeRescheduled;
use App\Notifications\FailedShipment;
use App\Notifications\NotAvailableConsignee;
use App\Notifications\OfficeCollection;
use App\Notifications\RejectedShipment;
use App\Traits\GenerateWaybills;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Traits\LogsActivity;
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
 * @property string external_notes
 * @property string status_notes
 * @property string reference
 * @property double total_price
 * @property boolean client_paid
 * @property boolean courier_cashed
 * @property Branch branch
 * @property Carbon created_at
 * @property User createdBy
 * @method static self statusIn(array $statuses, $boolean = 'and')
 * @method static self statusIs(string $status)
 * @method static self statusGroups(array $status_groups)
 * @method static self lodger(string $lodger)
 * @method static self unpaid()
 * @method static self pending()
 * @method static self today()
 * @method static self untilToday()
 * @method static self courierCashed(bool $value)
 * @method static self type(array $types)
 * @method static self withFilters(array $filters, &$appliedFilters = [])
 * @mixin Builder
 */
class Shipment extends Model
{
    use SoftDeletes, GenerateWaybills, RevisionableTrait;

    /** Revisionable Attributes */
    protected $revisionEnabled = true;
    protected $historyLimit = 500;
    protected $revisionCleanup = true;
    protected $revisionFormattedFields = array(
        'courier_cashed' => 'boolean:No|Yes',
        'client_paid' => 'boolean:No|Yes',
    );
    protected $dontKeepRevisionOf = [
        'created_by',
    ];

    /**
     * @var int
     */
    protected $waybill_digits = 8;
    /**
     * @var string
     */
    protected $waybill_prefix = "1";


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
        'reference',
        'is_guest',
        'branch_id'
    ];

    protected $dispatchesEvents = [
        'saving'  => Events\ShipmentSaving::class,
        'created' => Events\ShipmentCreated::class,
    ];

    /**
     * model life cycle event listeners
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function (Shipment $instance) {
            $instance->type = static::$waybill_type ?? "normal";
            $instance->createdBy()->associate(auth()->user());
        });

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|User
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
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
    public function guest()
    {
        return $this->belongsTo(Guest::class, 'client_account_number', 'id');
    }

    public function getIsGuestAttribute()
    {
        return !is_null($this->guest);
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
        $custom  = $address->customFor($this->client);
        if (!is_null($custom))
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

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function returnedIn()
    {
        return $this->hasOne(ReturnedShipment::class, "returned_from", "id");
    }

    public function hasReturned()
    {
        return $this->returnedIn()->exists();
    }

    public function isReturned()
    {
        return $this->hasReturned() && $this->isStatusGroup('delivered');
    }

    public function isReturnedShipment()
    {
        return $this->type === ReturnedShipment::$waybill_type;
    }

    /**
     * @param Builder $query
     * @param array $type
     * @param string $boolean
     * @return Builder
     */
    public function scopeType(Builder $query, array $type, string $boolean = 'and')
    {
        return $query->whereIn('type', $type, $boolean);
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
        $statuses = Status::whereJsonContains('groups', ['pending'])->pluck('id');
        return $query->whereIn('status_id', $statuses)->upcoming();
    }


    /**
     * @param $query
     * @return mixed
     */
    public function scopeCourierDashboard($query)
    {
        $todayDate = Carbon::now()->toDateString();
        $statuses  = Status::where('courier_dashboard', true)->pluck('id');
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

    public function scopeToday(Builder $query)
    {
        return $query->whereDate('delivery_date', '>=', Carbon::today()->startOfDay())
            ->whereDate('delivery_date', "<=", Carbon::today()->endOfDay());
    }

    public function scopeUntilToday(Builder $query)
    {
        return $query->whereDate('delivery_date', '<=', now()->endOfDay());
    }

    public function isStatus($status)
    {
        if (is_array($status)) {
            $s = Status::name('name', $status)->pluck('id');
            return in_array($this->status_id, $s->toArray());
        }
        if (is_string($status))
            $status = Status::name($status)->first();
        return $this->status->is($status);
    }

    public function isStatusGroup($group)
    {
        return in_array($group, $this->status->groups);
    }

    /**
     * @param Builder $query
     * @param array $statuses
     * @param string $boolean
     * @return Builder
     */
    public function scopeStatusIn(Builder $query, array $statuses, string $boolean = 'and')
    {
        $status_ids = Status::whereIn('name', $statuses)->pluck('id');
        return $query->whereIn('status_id', $status_ids, $boolean);
    }

    /**
     * @param Builder $query
     * @param array $status_groups
     * @param string $boolean
     * @return Builder
     */
    public function scopeStatusGroups(Builder $query, array $status_groups, string $boolean = 'and')
    {
        $status_ids = Status::group($status_groups)->pluck('id');
        return $query->whereIn('status_id', $status_ids, $boolean);
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
        if ($clientData['type'] == 'guest') {
            $guest = Guest::findOrCreateByNationalId($clientData['national_id'], [
                'trade_name'       => $clientData['name'],
                'phone_number'     => $clientData['phone_number'],
                'country'          => $clientData['country'] ?? "",
                'city'             => $clientData['city'] ?? "",
                'address_id'       => $clientData['address_id'] ?? null,
                'address_detailed' => $clientData['address_detailed'] ?? null,
            ]);
            $this->guest()->associate($guest);
        } else
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

        $zone                              = $this->address->zone;
        $this->base_weight_of_zone         = $zone->base_weight;
        $this->charge_per_unit_of_zone     = $zone->charge_per_unit;
        $this->extra_fees_per_unit_of_zone = $zone->extra_fees_per_unit;
    }

    /**
     * @return float|int
     */
    public function getExtraFeesAttribute()
    {
        if ($this->package_weight > $this->base_weight_of_zone) {
            $extra_weight = $this->package_weight - $this->base_weight_of_zone;
            $units        = ceil($extra_weight / $this->charge_per_unit_of_zone);
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
            /** @var Service $service */
            if (!is_null($this->client) && $custom_service = $service->customFor($this->client))
                $services_cost += $custom_service->pivot->price;
            else
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

    public function getNetAmountAttribute()
    {
        if ($this->statusIs(["rejected", 'cancelled'])) {
            return abs($this->delivery_cost - $this->actual_paid_by_consignee);
        }
        return $this->delivery_cost;
    }

    public function getCashOnDeliveryAttribute()
    {
        if ($this->service_type == 'courier')
            return $this->total_price;
        else
            return $this->shipment_value;
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
        foreach ($services as $service) {
            if (!$service instanceof Service) $service = Service::findOrFail($service);
            $syncData[$service->id] = ['price' => $service->price];
        }
        return $this->services()->sync($syncData);
    }

    /**
     * @param Builder $query
     * @param string $term
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $term)
    {
        $statuses  = Status::where("name", "like", "%$term%")->pluck('id');
        $couriers  = Courier::where("name", "like", "%$term%")->pluck('id');
        $addresses = Address::where("name", "like", "%$term%")->pluck('id');
        return $query->whereIn("status_id", $statuses)
            ->orWhere("waybill", "like", "%$term%")
            ->whereIn("courier_id", $couriers, "or")
            ->whereIn("address_id", $addresses, "or")
            ->orWhere("phone_number", "like", "%$term%")
            ->orWhere("shipment_value", "like", "%$term%")
            ->orWhere("actual_paid_by_consignee", "like", "%$term%");
    }

    public function scopeWithFilters(Builder $query, array $filters, &$appliedFilters = [])
    {
        $appliedFilters = $this->applyFilters($query, $filters);
        return $query;
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
        return !$this->status()->whereIn('name', ['delivered'])->exists() && !$this->hasReturned();
    }

    /**
     * @return $this
     */
    public function toggleClientPaid()
    {
        $this->client_paid = !$this->client_paid;
        return $this;
    }

    /**
     * @return $this
     */
    public function toggleCourierCashed()
    {
        $this->courier_cashed = !$this->courier_cashed;
        return $this;
    }

    public function notifyFor(Status $status)
    {
        if ($this->is_guest) return;
        if (!$this->client->shipments_email_updates) return;
        switch ($status->name) {
            case "not_available":
                $this->client->notify(new NotAvailableConsignee($this));
                break;
            case "consignee_rescheduled":
                $this->client->notify(new ConsigneeRescheduled($this));
                break;
            case "rejected":
                $this->client->notify(new RejectedShipment($this));
                break;
            case "cancelled":
                $this->client->notify(new CancelledShipment($this));
                break;
            case "failed":
                $this->client->notify(new FailedShipment($this));
                break;
            case "collect_from_office":
                $this->client->notify(new OfficeCollection($this));
                break;
        }
    }

    public static function routes()
    {
        Route::put('shipments/{shipment}/recalculate', "ShipmentController@recalculate")->name('shipments.recalculate');
        Route::put('shipments/assign-courier', "ShipmentController@assignCourier")->name('shipments.assignCourier');
        Route::get('shipments/returned', "ShipmentController@returned")->name('shipments.returned');
        Route::get('shipments/create/{type?}', "ShipmentController@create")
            ->name('shipments.create')
            ->where('type', 'wizard|legacy');
        Route::get('shipments/{shipment}/{tab?}', "ShipmentController@show")
            ->name('shipments.show')
            ->where('tab', 'summery|details|actions|status|changelog');
        Route::resource('shipments', "ShipmentController")->except(['create', 'show']);

        Route::put('shipments/{shipment}/return', "ShipmentController@makeReturn")->name('shipments.return');
        Route::put('shipments/{shipment}/delivery', "ShipmentController@updateDelivery")->name('shipments.delivery');

        Route::get('shipments/{shipment}/print', "ShipmentController@print")->name('shipments.print');
    }

}
