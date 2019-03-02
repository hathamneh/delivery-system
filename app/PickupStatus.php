<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class PickupStatus
 * @package App
 *
 * @property int id
 * @property string name
 * @property array options
 *
 * @method static self name(string|array $name, $boolean = 'and', $not = false)
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PickupStatus extends Model
{

    protected $attributes = [
        'options' => "[]",
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function pickups()
    {
        return $this->hasMany(Pickup::class);
    }

    /**
     * @param Builder $builder
     * @param string|array $name
     * @param bool $not
     * @param string $boolean
     * @return Builder
     */
    public function scopeName(Builder $builder, $name, $boolean = 'and', $not = false)
    {
        if (is_array($name))
            return $builder->whereIn('name', $name, $boolean, $not);
        return $builder->where('name', $not ? '!=' : '=', $name, $boolean);
    }
}
