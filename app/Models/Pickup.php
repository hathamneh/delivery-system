<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * @property Carbon available_time_start
 * @property Carbon available_time_end
 * @property string available_time
 * @property integer expected_packages_number
 * @property integer actual_packages_number
 * @property double pickup_fees
 * @property string pickup_from
 * @property string pickup_address_text
 * @property string pickup_address_maps
 * @property string notes_internal
 * @property string notes_external
 * @property PickupStatus pickupStatus
 * @property string phone_number
 * @property Client client
 * @property Courier courier
 * @property string identifier
 * @property integer id
 * @property string client_name
 * @property string client_national_id
 * @property boolean is_guest
 * @property string status_note
 * @property float prepaid_cash
 * @mixin Builder
 * @method static self pending()
 * @method static self notAlerted()
 * @method static self unpaid()
 * @method static self status(string|array $status, string $boolean = 'and', bool $not = false)
 * @method static self today()
 * @method static self search(string $term, string $type)
 */
class Pickup extends Model
{
    use SoftDeletes, RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit    = 75; // Stop tracking revisions after 75 changes have been made.


    protected $dates = ['deleted_at', 'available_time_start', 'available_time_end'];

    protected $fillable = [
        'available_time_start',
        'available_time_end',
        'available_time',
        'expected_packages_number',
        'actual_packages_number',
        'pickup_fees',
        'pickup_from',
        'pickup_address_text',
        'pickup_address_maps',
        'notes_internal',
        'notes_external',
        'status',
        'phone_number',
        'identifier',
        'alerted',
        'client_national_id',
        'is_guest',
        'prepaid_cash',
        'status_note'
    ];

    protected $dispatchesEvents        = [
        'saving' => Events\PickupSaving::class,
    ];
    protected $availableDateTimeFormat = 'M d, Y g:i A';
    protected $availableTimeFormat     = 'g:i A';

    public function shipments()
    {
        return $this->belongsToMany(Shipment::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_account_number', 'account_number');
    }

    public function PickupStatus()
    {
        return $this->belongsTo(PickupStatus::class);
    }

    public function getClientAttribute()
    {
        if ($this->is_guest)
            return Guest::whereNationalId($this->client_national_id)->first();
        else
            return $this->client()->first();
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function scopePending(Builder $query, $boolean = 'and')
    {
        $pendingIds = PickupStatus::name(['rejected', 'collected'], $boolean, true)->pluck('id');
        return $query->whereIn('status_id', $pendingIds);
    }

    public function scopeToday(Builder $query)
    {
        return $query->whereDate('available_time_start', '>=', Carbon::today()->startOfDay())
            ->whereDate('available_time_end', '<=', Carbon::today()->endOfDay());
    }

    public function scopeSearch(Builder $query, string $term, string $type)
    {
        if ($type === "courier") {
            $query->whereIn('courier_id', function ($whereQuery) use ($term) {
                $whereQuery->select("id")
                    ->from('couriers')
                    ->where("name", "LIKE", "%$term%");
            });
        } else {
            $query->whereIn('client_account_number', function ($whereQuery) use ($term) {
                $whereQuery->select('account_number')
                    ->from('clients')
                    ->where('account_number', '=', $term)
                    ->orWhere('name', 'LIKE', "%$term%")
                    ->orWhere('trade_name', 'LIKE', "%$term%");
            });
        }
    }

    /**
     * @param Builder $query
     * @param string|array $status
     * @param string $boolean
     * @param bool $not
     * @return Builder
     */
    public function scopeStatus(Builder $query, $status, $boolean = 'and', $not = false)
    {
        $statusIds = PickupStatus::name($status, $boolean, $not)->pluck('id');
        return $query->whereIn('pickup_status_id', $statusIds);
    }

    public function scopeNotAlerted($query)
    {
        return $query->where('alerted', false);
    }

    public function getClientNameAttribute()
    {
        return $this->client_name ?? $this->client->trade_name;
    }

    public function getAvailableDateTimeAttribute()
    {
        return Carbon::createFromTimeString($this->attributes['available_time_start'])->format($this->availableDateTimeFormat) .
            " - " . Carbon::createFromTimeString($this->attributes['available_time_end'])->format($this->availableDateTimeFormat);
    }

    public function getTimeStartAttribute()
    {
        return $this->available_time_start->format('h:ia');
    }

    public function getTimeEndAttribute()
    {
        return $this->available_time_end->format('h:ia');
    }

    public function getAvailableDayAttribute()
    {
        return $this->available_time_start->format('j/n/Y');
    }

    public function statusContext($context = null)
    {
        switch ($this->pickupStatus->name) {
            case "collected":
                switch ($context) {
                    case 'card':
                        return "border-success";
                    case 'text':
                        return '<small class="text-success"><i class="fa-check-circle2"></i> <span>' . trans('pickup.statuses.collected') . '</span></small>';
                    default:
                        return "success";
                }
            case 'rejected':
                switch ($context) {
                    case 'card':
                        return "border-danger";
                    case 'text':
                        return '<small class="text-danger"><i class="fa-minus-circle"></i> <span>' . trans("pickup.statuses.rejected") . '</span>' .
                            ' - ' . $this->status_note .
                            '</small>';
                    default:
                        return "danger";
                }
            default:
                switch ($context) {
                    case 'card':
                        return "";
                    case 'text':
                        return '<small><i class="fa-clock"></i> <span>' . trans("pickup.statuses.{$this->pickupStatus->name}") . '</span>' .
                            ' - ' . $this->status_note .
                            '</small>';
                    default:
                        return "";
                }
        }
    }

    public function generateIdentifier($length = 6)
    {
        while (true) {
            $characters       = '0123456789AEFHIOKLQRVXZ'; /* 85K POSSIBLE COMBINATIONS ONLY  !! */
            $charactersLength = strlen($characters);
            $randomString     = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            if (!self::findWithIdentifier($randomString)) {
                $this->identifier = $randomString;
                return;
            }
        }
    }

    public static function findWithIdentifier($identifier)
    {
        return static::where('identifier', $identifier)->first() ?? false;
    }

    public function scopeUnpaid(Builder $query)
    {
        return $query->where('is_fees_paid', false);
    }

    public static function routes()
    {
        Route::put('pickups/{pickup}/actions', "PickupsController@actions")->name('pickups.actions');
        Route::resource('pickups', "PickupsController");
    }
}
