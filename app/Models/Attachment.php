<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function upload()
    {
        // todo
    }
}
