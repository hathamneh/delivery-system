<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Pickup extends Model
{
    use SoftDeletes, RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 75; // Stop tracking revisions after 75 changes have been made.


    protected $dates = ['deleted_at', 'available_time_start', 'available_time_end'];

    public function shipments()
    {
        return $this->belongsToMany(Shipment::class);
    }
}
