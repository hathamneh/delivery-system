<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Inventory extends Model
{
    /**
     * @var Client|Courier
     */
    private $target;

    /**
     * @var Carbon
     */
    private $from;

    /**
     * @var Carbon
     */
    private $until;

    /**
     * @param Carbon $from
     * @param Carbon $until
     * @param Client|Courier|null $target
     * @return Inventory
     */
    public static function createGeneric($from, $until, $target = null): self
    {
        $inventory = new self();
        $inventory->from = $from;
        $inventory->until = $until;
        $inventory->target = $target;
        return $inventory;
    }

    /**
     * @param Client|Courier|null $target
     * @return Inventory
     */
    public static function createForToday($target = null): self
    {
        return self::createGeneric(now()->startOfDay(), now()->endOfDay(), $target);
    }

    public function shipments()
    {
        return $this->target->shipments()
            ->whereDate('delivery_date', '>=', $this->from)
            ->whereDate('delivery_date', "<=", $this->until)
            ->get();
    }

    public function clients()
    {
        return Client::join('shipments', function ($join) {
            $join->on('clients.account_number', '=', 'shipments.client_account_number')
                ->whereDate('shipments.delivery_date', '>=', $this->from)
                ->whereDate('shipments.delivery_date', "<=", $this->until);
        })->get();
    }

    /**
     * @param $value
     */
    public function setPeriodAttribute($value)
    {
        $dates = explode(' - ', $value);
        $this->from = Carbon::createFromFormat('M d, Y', $dates[0])->startOfDay();
        $this->until = Carbon::createFromFormat('M d, Y', $dates[1])->endOfDay();
    }

    /**
     * @return string
     */
    public function getPeriodAttribute()
    {
        if($this->from->diffInDays($this->until) === 0)
            return $this->from->toFormattedDateString();
        return $this->from->toFormattedDateString() . " - " . $this->until->toFormattedDateString();
    }

    /**
     * @param Carbon $from
     */
    public function setFrom(Carbon $from): void
    {
        $this->from = $from;
    }

    /**
     * @param Carbon $until
     */
    public function setUntil(Carbon $until): void
    {
        $this->until = $until;
    }

    public static function routes()
    {
        Route::get('inventory', 'InventoryController@index')->name('inventory.index');
        Route::get('inventory/courier', 'InventoryController@courier')->name('inventory.courier');
    }
}
