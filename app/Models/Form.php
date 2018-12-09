<?php

namespace App;

use App\Traits\HasAttachmentsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

/**
 * Class Form
 * @package App
 * @property string name
 * @property string description
 * @property string path
 */
class Form extends Model
{
    use HasAttachmentsTrait;

    protected $folderToUpload = 'forms';

    protected $fillable = [
        'name',
        'description',
        'path'
    ];

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (Form $instance) {
            foreach ($instance->attachments as $attachment) {
                /** @var Attachment $attachment */
                $attachment->delete();
            }
        });
    }

    public static function routes()
    {
        Route::resource('forms', "FormsController");
    }


}
