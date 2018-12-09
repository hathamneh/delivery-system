<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder;

/**
 * Class Status
 * @package App
 * @property string name
 * @property string description
 * @property SubStatus sub_statuses
 * @property array suggested_reasons
 * @property integer id
 * @method static Status name(string $name)
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Status extends Model
{

    protected $casts = [
        'suggested_reasons' => 'array',
    ];

    public function subStatuses()
    {
        return $this->hasMany(SubStatus::class);
    }

    public function customCharges()
    {
        return $this->hasMany(ClientChargedFor::class);
    }

    public function nextStatuses()
    {
        return $this->belongsToMany(Status::class, 'statuse_cycle', 'status_id', 'next_id');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function scopeName($query, $name)
    {
        if(is_array($name))
            return $query->whereIn('name', $name);
        return $query->where('name', $name);
    }

    public function identifiableName()
    {
        return trans("shipment.statuses." . $this->name);
    }

}
