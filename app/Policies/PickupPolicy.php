<?php

namespace App\Policies;

use App\Pickup;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PickupPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin())
            return true;
    }

    /**
     * Determine whether the user can view all shipments.
     *
     * @param  \App\User $user
     * @return boolean
     */
    public function index(User $user)
    {
        return $user->isAuthorized('pickups', Role::UT_READ);
    }

    /**
     * Determine whether the user can view the shipment.
     *
     * @param  \App\User  $user
     * @param  \App\Pickup  $pickup
     * @return boolean
     */
    public function view(User $user, Pickup $pickup)
    {
        return $user->isAuthorized('pickups', Role::UT_READ)
            && ($user->client->account_number == $pickup->client_account_number ?? false);
    }

    /**
     * Determine whether the user can create shipments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAuthorized('pickups', Role::UT_CREATE);
    }

    /**
     * Determine whether the user can update the shipment.
     *
     * @param  \App\User $user
     * @param Pickup $pickup
     * @return mixed
     */
    public function update(User $user, Pickup $pickup)
    {
        return $user->isAuthorized('pickups', Role::UT_UPDATE)
            && $pickup->client_account_number == $user->client->account_number;
    }

    /**
     * Determine whether the user can delete the shipment.
     *
     * @param  \App\User $user
     * @param Pickup $pickup
     * @return mixed
     */
    public function delete(User $user, Pickup $pickup)
    {
        return $user->isAuthorized('pickups', Role::UT_DELETE)
            && $pickup->client_account_number == $user->client->account_number;
    }
}
