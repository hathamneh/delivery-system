<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    protected $casts = [
        'suggested_reasons' => 'array',
    ];

    public function subStatuses()
    {
        return $this->hasMany(SubStatus::class);
    }

    public function customCharges() {
        return $this->hasMany(ClientChargedFor::class);
    }

    public function nextStatuses() {
        return $this->belongsToMany(Status::class, 'statuse_cycle', 'status_id', 'next_id');
    }
}
