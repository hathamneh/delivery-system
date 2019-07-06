<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/**
 * @property int id
 * @property boolean private
 * @property string text
 * @property User user
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

    public function read()
    {
        return $this->belongsToMany(User::class);
    }

    public function isRead()
    {
        return DB::table('note_user')
            ->where('user_id', '=', $this->user->id)
            ->where('note_id', '=', $this->id)
            ->exists();
    }
}
