<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property integer id
 * @property string name
 * @property double base_weight
 * @property double charge_per_unit
 * @property double extra_fees_per_unit
 * @property Collection addresses
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

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }


    public function couriers()
    {
        return $this->hasMany(Courier::class);
    }

}
