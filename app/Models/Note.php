<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

/**
 * @property boolean private
 * @property string text
 */
class Note extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'text',
        'type',
        'private'
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

    public static function routes()
    {
        Route::resource('notes', "NotesController");
    }
}
