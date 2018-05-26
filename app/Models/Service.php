<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function customClients()
    {
        return $this->belongsToMany(Client::class)->withPivot('price');
    }
}
