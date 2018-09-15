<?php

namespace App;

use App\Presenters\Address\UrlPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property string name
 * @property double sameday_price
 * @property double scheduled_price
 * @property Zone zone
 * @property Collection customAddresses
 */
class Address extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'sameday_price',
        'scheduled_price',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function (Address $address) {
            if (!$address instanceof CustomAddress)
                if (!is_null($customAddresses = $address->customAddresses)) {
                    foreach ($customAddresses as $customAddress) {
                        $customAddress->name = $address->name;
                        $customAddress->save();
                    }
                }
        });

        static::deleting(function (Address $address) {
            if (!$address instanceof CustomAddress)
                if (!is_null($customAddresses = $address->customAddresses)) {
                    foreach ($customAddresses as $customAddress) {
                        $customAddress->delete();
                    }
                }
        });
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function customAddresses()
    {
        return $this->hasMany(CustomAddress::class, 'address_id', 'id');
    }

    /**
     * @param Client|Guest $client
     * @return mixed
     */
    public function customFor($client)
    {
        if ($client instanceof $client)
            return CustomAddress::where('address_id', $this->id)->where('client_account_number', $client->account_number)->first();
        return null;
    }

    public function identifiableName()
    {
        return $this->name;
    }

    public function getUrlAttribute()
    {
        return new UrlPresenter($this);
    }
}
