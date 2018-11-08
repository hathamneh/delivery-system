<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{

    protected $fillable = [
        'name',
        'path',
        'type',
        'url',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($instance) {
            if(!Storage::disk('public')->delete($instance->path))
                return false;
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'author_id');
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class, 'author_id');
    }

    public function forms()
    {
        return $this->belongsTo(Form::class, 'author_id');
    }

    public static function routes()
    {
        Route::delete('attachment/{attachment}', "AttachmentController@destroy")->name('attachment.destroy');
    }
}
