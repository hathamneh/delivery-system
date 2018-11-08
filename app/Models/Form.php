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

    public static function routes()
    {
        Route::resource('forms', "FormsController");
    }


}
