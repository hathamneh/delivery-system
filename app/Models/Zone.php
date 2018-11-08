<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/**
 * @property integer id
 * @property string name
 * @property double base_weight
 * @property double charge_per_unit
 * @property double extra_fees_per_unit
 * @property Collection addresses
 * @property Collection customZones
 * @mixin Builder
 */
class Zone extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'base_weight',
        'charge_per_unit',
        'extra_fees_per_unit',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Zone $zone) {
            DB::table('custom_zones')->where('zone_id', $zone->id)->delete();
        });
    }


    public function addresses()
    {
        return $this->hasMany(Address::class);
    }


    public function couriers()
    {
        return $this->hasMany(Courier::class);
    }

    public function customZones()
    {
        return $this->hasMany(CustomZone::class, 'zone_id', 'id');
    }

    public static function routes()
    {
        Route::resource('zones', "ZoneController");
        Route::resource('zones/{zone}/address', "AddressController");
        Route::put('zones/address/bulk', "AddressController@bulkUpdate")->name('addresses.bulkUpdate');
    }
}
