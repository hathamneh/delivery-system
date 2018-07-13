<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public const UT_NO_ACCESS = 0;
    public const UT_READ = 1;
    public const UT_CREATE = 2;
    public const UT_UPDATE = 3;
    public const UT_DELETE = 4;

    protected $fillable = ['name', 'default'];

    public function templates()
    {
        return $this->hasMany(UserTemplate::class);
    }

}
