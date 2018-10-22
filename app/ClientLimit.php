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
 */
class ClientLimit extends Model
{
    protected $fillable = [
        'name',
        'value',
        'appliedOn',
        'penalty',
    ];

    protected $casts = [
        'appliedOn' => 'array'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_account_number', 'account_number');
    }

}
