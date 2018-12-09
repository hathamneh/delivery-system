<?php

namespace App\Policies;

use App\Service;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
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
        return $user->isAuthorized('services', Role::UT_READ);
    }

    /**
     * Determine whether the user can view the shipment.
     *
     * @param  \App\User $user
     * @param Service $service
     * @return boolean
     */
    public function view(User $user, Service $service)
    {
        return $user->isAuthorized('services', Role::UT_READ);
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
     * @param Service $service
     * @return mixed
     */
    public function update(User $user, Service $service)
    {
        return $user->isAuthorized('services', Role::UT_UPDATE);
    }

    /**
     * Determine whether the user can delete the shipment.
     *
     * @param  \App\User $user
     * @param Service $service
     * @return mixed
     */
    public function delete(User $user, Service $service)
    {
        return $user->isAuthorized(' services', Role::UT_DELETE);
    }
}
