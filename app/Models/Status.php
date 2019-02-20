<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Builder;

/**
 * Class Status
 * @package App
 * @property string name
 * @property array groups
 * @property array options
 * @property integer id
 * @method static Builder name(string $name)
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Status extends Model
{

    protected $attributes = [
        'options' => "[]",
    ];

    protected $casts = [
        'options' => 'array',
        'groups' => 'array',
    ];

    protected $fillable = [
        "name",
        "groups",
        "options",
    ];

    public function subStatuses()
    {
        return $this->hasMany(SubStatus::class);
    }

    public function customCharges()
    {
        return $this->hasMany(ClientChargedFor::class);
    }

    public function nextStatuses()
    {
        return $this->belongsToMany(Status::class, 'statuse_cycle', 'status_id', 'next_id');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function scopeName($query, $name)
    {
        if(is_array($name))
            return $query->whereIn('name', $name);
        return $query->where('name', $name);
    }

    /**
     * @param Builder $query
     * @param array $groups
     * @param bool $not
     */
    public function scopeGroup(Builder $query, array $groups, bool $not = false)
    {
        if($not)
            $query->whereJsonDoesntContain('groups', $groups);
        else
            $query->whereJsonContains('groups', $groups);
    }

    public function identifiableName()
    {
        return trans("shipment.statuses.{$this->name}.name");
    }

}
