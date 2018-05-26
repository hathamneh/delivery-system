<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Setting extends Model
{
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 5; // Stop tracking revisions after 75 changes have been made.

    public static function get(string $key)
    {
        return self::where('name', $key)->first();
    }

    public function __toString()
    {
        return $this->value;
    }
}
