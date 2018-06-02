<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'sameday_price',
        'scheduled_price',
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function customizedClients()
    {
        return $this->belongsToMany(Client::class)->withPivot('sameday_price', 'scheduled_price');
    }
}
