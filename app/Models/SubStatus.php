<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubStatus extends Model
{

    protected $casts = [
        'suggested_reasons' => 'array',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }


    public function identifiableName()
    {
        return trans("shipment.statuses." . $this->name);
    }
}
