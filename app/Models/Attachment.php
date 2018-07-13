<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{

    protected $fillable = [
        'name',
        'path',
        'type',
        'url',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'author_id');
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class, 'author_id');
    }
}
