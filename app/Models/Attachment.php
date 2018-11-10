<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/**
 * Class Attachment
 * @package App
 * @property string name
 * @property string path
 * @property string type
 * @property string url
 * @property string file
 */
class Attachment extends Model
{

    protected $fillable = [
        'name',
        'path',
        'type',
        'url',
        'author_type'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($instance) {
            File::delete($instance->path);
        });


    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'author_id')->where('author_type', Client::class);
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class, 'author_id')->where('author_type', Courier::class);
    }

    public function forms()
    {
        return $this->belongsTo(Form::class, 'author_id')->where('author_type', Form::class);
    }

    public static function routes()
    {
        Route::delete('attachment/{attachment}', "AttachmentController@destroy")->name('attachment.destroy');
        Route::get('attachment/{attachment}/download', 'AttachmentController@download')->name('attachment.download');

    }

    public function getFileAttribute()
    {
        return Storage::get($this->path);
    }

}
