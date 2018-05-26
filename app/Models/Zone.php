<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function customizedClients()
    {
        return $this->belongsToMany(Client::class)->withPivot('base_weight','charge_per_unit','extra_fees_per_unit');
    }

    public function couriers()
    {
        return $this->hasMany(Courier::class);
    }
}
