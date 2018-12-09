<?php

namespace App\Policies;

use App\Form;
use App\Role;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormPolicy
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
        return $user->isAuthorized('forms', Role::UT_READ);
    }

    /**
     * Determine whether the user can view the shipment.
     *
     * @param  \App\User $user
     * @param Form $form
     * @return boolean
     */
    public function view(User $user, Form $form)
    {
        return $user->isAuthorized('forms', Role::UT_READ);
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
     * @param Form $form
     * @return mixed
     */
    public function update(User $user, Form $form)
    {
        return $user->isAuthorized('forms', Role::UT_UPDATE);
    }

    /**
     * Determine whether the user can delete the shipment.
     *
     * @param  \App\User $user
     * @param Form $form
     * @return mixed
     */
    public function delete(User $user, Form $form)
    {
        return $user->isAuthorized(' forms', Role::UT_DELETE);
    }
}
