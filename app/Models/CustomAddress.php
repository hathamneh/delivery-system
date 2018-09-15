<?php

namespace App;

/**
 * @property Address originalAddress
 */
class CustomAddress extends Address
{

    public function zone()
    {
        return $this->belongsTo(CustomZone::class, 'custom_zone_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function originalAddress()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function getNameAttribute()
    {
        if(is_null($this->attributes['name']))
            return $this->originalAddress->name;
        return $this->name;
    }

    public static function createFromAddress(Address $address, CustomZone $zone, Client $client)
    {
        $customAddress = new static;
        $customAddress->sameday_price = $address->sameday_price;
        $customAddress->scheduled_price = $address->scheduled_price;
        $customAddress->originalAddress()->associate($address);
        $customAddress->client()->associate($client);
        $customAddress->zone()->associate($zone);
        return $customAddress;
    }

    public function isNew()
    {
        return is_null($this->originalAddress);
    }

    public function getHtmlClassAttribute()
    {
        return $this->isNew() ? 'new' : 'modified';
    }
}
