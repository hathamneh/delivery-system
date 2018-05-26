<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courier extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'password' .
        'phone_number',
        'address',
        'category',
        'notes',
        'doc1',
        'doc2'
    ];

    public function scopeHaveSmiley($query)
    {
        $thirtyDaysBefore = date("d-m-Y", strtotime("- 30 days"));
        $ShipmentsCountForSmiley = intval(Setting::get("promotion_requirement")->value) ?? 30;

        return $query->leftJoin('shipments', 'couriers.id', '=', 'shipments.courier_id')
            ->where('shipments.delivery_date', ">", $thirtyDaysBefore)
            ->groupBy('shipments.id')->havingRaw("count(`shipments`.`id`) > $ShipmentsCountForSmiley");
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'identifier', 'id');
    }


}
