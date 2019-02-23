<?php

namespace App;

use App\Interfaces\Accountable;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * @property Carbon until
 * @property Carbon from
 * @property Accountable target
 * @property string type
 * @property Collection shipments
 * @property string period
 * @property float discount
 * @property float due_for
 * @property float due_from
 * @property float pickup_fees
 * @property float total
 * @property float terms_applied
 * @property float payment_method_price
 * @property Carbon decision_date
 * @property User decisionBy
 *
 * @method static self open(string $boolean = "and", bool $not = false)
 * @method static self closed(string $boolean = "and")
 * @method static self closedToday(string $boolean = "and")
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Invoice extends Model
{
    protected $fillable = [
        'type',
        'target',
        'from',
        'until',
        'discount',
        'notes',
        'decision_date'
    ];

    protected $dates = [
        'from',
        'until',
        'decision_date'
    ];

    /**
     * @param $value
     */
    public function setPeriodAttribute($value)
    {
        $dates       = explode(' - ', $value);
        $this->from  = Carbon::createFromFormat('M d, Y', $dates[0])->startOfDay();
        $this->until = Carbon::createFromFormat('M d, Y', $dates[1])->endOfDay();
    }

    /**
     * @return string
     */
    public function getPeriodAttribute()
    {
        if ($this->from->diffInDays($this->until) === 0)
            return $this->from->toFormattedDateString();
        return $this->from->toFormattedDateString() . " - " . $this->until->toFormattedDateString();
    }

    /**
     * @return Shipment
     */
    public function shipments()
    {
        $shipments = Shipment::statusIn(['delivered', 'returned', 'rejected', 'cancelled'])
            ->whereBetween('delivery_date', [$this->from, $this->until]);

        if ($this->type == "client")
            return $shipments->where('client_account_number', $this->target->account_number);
        elseif ($this->type == "courier")
            return $shipments->where('courier_id', $this->target->id);
        elseif ($this->type == "guest")
            return $shipments->where('client_account_number', $this->target->id);
        return $shipments;
    }

    public function decisionBy()
    {
        return $this->belongsTo(User::class, 'decision_by', 'id');
    }

    public function scopeForClientsAndGuests($query)
    {
        return $query->whereIn('type', ['client', 'guest']);
    }

    public function scopeOpen($query, string $boolean = "and", bool $not = false)
    {
        return $query->whereNull("decision_date", $boolean, $not);
    }

    public function scopeClosed($query, string $boolean = "and")
    {
        return $query->open($boolean, true);
    }

    public function scopeClosedToday($builder, string $boolean = "and")
    {
        return $builder->whereDate("decision_date", ">=", now()->startOfDay(), $boolean);
    }

    /**
     * @return Collection
     */
    public function getShipmentsAttribute()
    {
        return $this->shipments()->get();
    }

    public function getTargetAttribute()
    {
        $value = $this->attributes['target'];
        if ($this->type == "client")
            return Client::find($value);
        else if ($this->type == "courier")
            return Courier::find($value);
        else if ($this->type == "guest")
            return Guest::find($value);
        return null;
    }


    public function getPaymentAttribute()
    {
        if ($this->target instanceof Accountable)
            return $this->target->payment($this);
        return 0;
    }

    /**
     * @return Pickup
     */
    public function pickups()
    {
        $pickups = Pickup::unpaid()
            ->completed()
            ->whereBetween('updated_at', [$this->from, $this->until]);

        if ($this->type == "client")
            return $pickups->where('client_account_number', $this->target->account_number);
        elseif ($this->type == "courier")
            return $pickups->where('courier_id', $this->target->id);
        elseif ($this->type == "guest")
            return $pickups->where('client_national_id', $this->target->national_id);
        return $pickups;
    }

    /**
     * @return Pickup[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPickupsAttribute()
    {
        return $this->pickups()->get();
    }

    /**
     * @return float|array
     */
    public function getDueForAttribute()
    {
        if ($this->target instanceof Accountable)
            return $this->target->dueFor($this);
        return 0;
    }

    /**
     * @return float
     */
    public function getDueFromAttribute()
    {
        if ($this->target instanceof Accountable)
            return $this->target->dueFrom($this);
        return 0;
    }

    public function getTermsAppliedAttribute()
    {
        if ($this->target instanceof Client)
            return $this->target->extraTermsApplied($this);
        return false;

    }

    public function getTheDiscountAttribute()
    {
        return fnumber(-1 * $this->discount) . "%";
    }

    public function getPickupFeesAttribute()
    {
        return $this->pickups()->sum('pickup_fees');
    }

    public function getPaymentMethodCostAttribute()
    {
        if ($this->target instanceof Client)
            return $this->target->payment_method_price;
        return 0;
    }

    public function getTotalAttribute()
    {
        if ($this->target instanceof Courier) {
            $dueForArr = $this->due_for;
            $dueFor    = $dueForArr['share'] + $dueForArr['promotion'];
        } else {
            $dueFor = $this->due_for;
        }
        $net = abs($this->due_from - $dueFor);
        if ($this->discount > 0) {
            $net -= $net * ($this->discount / 100);
        }
        if ($this->terms_applied)
            $net += $this->terms_applied;

        $net += $this->payment_method_price;
        $net += $this->pickup_fees;

        return $net;
    }

    public function getClientPaidAttribute()
    {
        return !$this->shipments()->where('client_paid', false)->exists();
    }

    public function getCourierCashedAttribute()
    {
        return !$this->shipments()->where('courier_cashed', false)->exists();
    }

    public function markAsClientPaid()
    {
        foreach ($this->shipments as $shipment) {
            /** @var Shipment $shipment */
            $shipment->update([
                'client_paid' => true
            ]);
        }
        $this->setDecided();
    }

    public function markAsCourierCashed()
    {
        foreach ($this->shipments as $shipment) {
            /** @var Shipment $shipment */
            $shipment->update([
                'courier_cashed' => true
            ]);
        }
        $this->setDecided();
    }

    public function setDecided()
    {
        $this->decision_date = now();
        $user                = Auth::user();
        $this->decisionBy()->associate($user);
        $this->save();
    }

    public static function routes()
    {
        Route::get('accounting', "AccountingController@index")->name('accounting.index');
        Route::post('accounting/invoice', "AccountingController@store")->name('accounting.store');
        Route::get('accounting/invoice/{invoice}', "AccountingController@show")->name('accounting.invoice');
        Route::get('accounting/goto', "AccountingController@goto")->name('accounting.goto');
        Route::put('accounting/client/{invoice}', "AccountingController@markAsPaid")->name('accounting.paid');

    }

}
