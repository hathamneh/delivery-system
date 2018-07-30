<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'text',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeTypePublic(Builder $builder)
    {
        return $builder->where('private', false);
    }

    public function scopeTypePrivate(Builder $builder, User $user)
    {
        return $builder->where('user_id', $user->id)->where('private', true);
    }
}
