<?php

namespace App\Policies;

use App\Role;
use App\User;
use App\Courier;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouriersPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        return $user->isAdmin();
    }


    /**
     * Determine whether the user can view all couriers.
     *
     * @param  \App\User $user
     * @return boolean
     */
    public function index(User $user)
    {
        return $user->isAuthorized('couriers', Role::UT_READ);
    }

    /**
     * Determine whether the user can view the courier.
     *
     * @param  \App\User  $user
     * @param  \App\Courier  $courier
     * @return mixed
     */
    public function view(User $user, Courier $courier)
    {
        return $user->courier->id == $courier->id;
    }

    /**
     * Determine whether the user can create couriers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAuthorized('couriers', Role::UT_CREATE);
    }

    /**
     * Determine whether the user can update the courier.
     *
     * @param  \App\User  $user
     * @param  \App\Courier  $courier
     * @return mixed
     */
    public function update(User $user, Courier $courier)
    {
        return $user->isAuthorized('couriers', Role::UT_UPDATE);
    }

    /**
     * Determine whether the user can delete the courier.
     *
     * @param  \App\User  $user
     * @param  \App\Courier  $courier
     * @return mixed
     */
    public function delete(User $user, Courier $courier)
    {
        return $user->isAuthorized('couriers', Role::UT_DELETE);
    }
}
