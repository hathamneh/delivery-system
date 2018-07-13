<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property Collection roles
 * @property Collection the_roles
 * @property mixed name
 */
class UserTemplate extends Model
{

    protected $fillable = ['name', 'description', 'deletable', 'editable', 'default'];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('value')->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getTheRolesAttribute()
    {
        $out = [];
        $roles = $this->roles->count() ? $this->roles : Role::all();
        foreach ($roles as $role)
            $out[] = [
                'id'    => $role->id,
                'name'  => $role->name,
                'value' => $role->pivot->value ?? $role->default
            ];
        return collect($out);
    }

    /**
     * @param string|array $roles
     * @param int|null $accessLevel
     * @return bool
     */
    public function authorizeRoles($roles, $accessLevel = null)
    {
        if (is_array($roles)) {
            return $this->hasAllRoles($roles) ||
                abort(401, 'This action is unauthorized.');
        }
        return $this->hasRole($roles, $accessLevel) ||
            abort(401, 'This action is unauthorized.');
    }

    /**
     * Check multiple roles
     * @param array $roles
     * @return bool
     */
    public function hasAllRoles($roles)
    {
        foreach ($roles as $role => $accessLevel) {
            if ($this->hasRole($role, $accessLevel))
                return false;
        }
        return true;
    }

    /**
     * Check one role
     * @param string $role
     * @param int $accessLevel
     * @return bool
     */
    public function hasRole($role, $accessLevel)
    {
        return $this->roles()->where('name', $role)->where('value', '>=', $accessLevel)->exists();
    }

    public function scopeDefault($query)
    {
        return $query->where('default', true);
    }
}
