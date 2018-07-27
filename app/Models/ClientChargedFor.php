<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientChargedFor
 * @package App
 *
 * @property int $id
 * @property Client $client
 * @property Status $status
 * @property boolean $enabled
 * @property string $type
 */
class ClientChargedFor extends Model
{

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function status()
    {
        return $this->belongsTo('status');
    }
}
