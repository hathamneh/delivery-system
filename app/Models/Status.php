<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 * @package App
 * @property string name
 * @property string description
 * @property SubStatus sub_statuses
 * @property array suggested_reasons
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

    public function identifiableName()
    {
        return trans("shipment.statuses." . $this->name);
    }
}
