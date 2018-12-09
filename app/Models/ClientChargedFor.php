<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientChargedFor
 * @package App
 *
 * @property int $id
 * @property Client $client
 * @property Status $status
 * @property boolean $enabled
 * @property string $type
 * @property mixed value
 * @method static self byStatus(string $string)
 * @method static self clientIs(Client $client)
 * @mixin Builder
 */
class ClientChargedFor extends Model
{

    protected $table = "client_charged_for";

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function scopeByStatus(Builder $builder, $statusName)
    {
        $status = Status::name($statusName)->first();
        return $builder->where('status_id', $status->id);
    }

    public function scopeClientIs(Builder $query, Client $client)
    {
        return $query->where('client_account_number', $client);
    }

    public function compute(float $delivery_cost)
    {
        if($this->type == 'fixed')
            return $this->value;
        elseif($this->type == "percentage")
            return $delivery_cost * ($this->value / 100);

        // otherwise
        return $delivery_cost;
    }

}
