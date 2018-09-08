<?php

namespace App\Policies;

use App\Zone;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ZonePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view all shipments.
     *
     * @param  \App\User $user
     * @return boolean
     */
    public function index(User $user)
    {
        return $user->isAuthorized('zones', Role::UT_READ);
    }

    /**
     * Determine whether the user can view the shipment.
     *
     * @param  \App\User $user
     * @param Zone $zone
     * @return boolean
     */
    public function view(User $user, Zone $zone)
    {
        return $user->isAuthorized('zones', Role::UT_READ);
    }

    /**
     * Determine whether the user can create shipments.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAuthorized('shipments', Role::UT_CREATE);
    }

    /**
     * Determine whether the user can update the shipment.
     *
     * @param  \App\User $user
     * @param Zone $zone
     * @return mixed
     */
    public function update(User $user, Zone $zone)
    {
        return $user->isAuthorized('zones', Role::UT_UPDATE);
    }

    /**
     * Determine whether the user can delete the shipment.
     *
     * @param  \App\User $user
     * @param Zone $zone
     * @return mixed
     */
    public function delete(User $user, Zone $zone)
    {
        return $user->isAuthorized(' zones', Role::UT_DELETE);
    }
}
