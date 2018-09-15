<?php

namespace App;

use Illuminate\Support\Collection;

/**
 * @property Client client
 * @property Zone originalZone
 * @property Collection customAddresses
 */
class CustomZone extends Zone
{

    public static function createFromZone(Zone $origianlZone, Client $client)
    {
        $new = new static;
        $new->name = $origianlZone->name;
        $new->base_weight = $origianlZone->base_weight;
        $new->charge_per_unit = $origianlZone->charge_per_unit;
        $new->extra_fees_per_unit = $origianlZone->extra_fees_per_unit;
        $new->originalZone()->associate($origianlZone);
        $new->client()->associate($client);
        return $new;
    }

    public function customAddresses()
    {
        return $this->hasMany(CustomAddress::class);
    }

    public function getAddressesAttribute()
    {
        $customizedIDs = $this->customAddresses()->pluck('address_id')->filter(function ($value, $key) {
            return !is_null($value);
        });
        if ($customizedIDs->count())
            $originalAddresses = $this->originalZone->addresses()->whereNotIn('id', $customizedIDs)->get();
        else
            $originalAddresses = $this->originalZone->addresses;

        return $this->customAddresses->concat($originalAddresses);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function originalZone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function getNameAttribute()
    {
        if(is_null($this->attributes['name']))
            return $this->originalZone->name;
        return $this->name;
    }

    public function url($for)
    {
        switch ($for) {
            case 'index':
                return route("clients.zones.$for", ['client' => $this->client]);
                break;
            case 'show':
                return route('clients.addresses.index', [$this->client, $this]);
            case 'update':
            case 'delete':
                return route("clients.zones.$for", ['client' => $this->client, 'zone' => $this->id]);
                break;
        }
        return '';
    }
}
