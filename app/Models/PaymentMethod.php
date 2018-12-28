<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentMethod
 * @package App
 *
 * @property string name
 * @property Collection clients
 */
class PaymentMethod extends Model
{

    protected $fillable = [
        "name"
    ];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
