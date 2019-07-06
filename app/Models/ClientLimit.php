<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientLimit
 * @package App
 * @property integer id
 * @property Client client
 * @property string name
 * @property float value
 * @property array appliedOn
 * @property float penalty
 * @property string type
 */
class ClientLimit extends Model
{
    protected $fillable = [
        'name',
        'value',
        'appliedOn',
        'penalty',
        'type'
    ];

    protected $casts = [
        'appliedOn' => 'array'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_account_number', 'account_number');
    }

    public function compute(float $delivery_cost)
    {
        if($this->type == 'fixed')
            return $this->penalty;
        elseif($this->type == "percentage")
            return $delivery_cost * ($this->penalty / 100);

        // otherwise
        return $delivery_cost;
    }

}
