<?php

namespace App\Policies;

use App\Role;
use App\User;
use App\Shipment;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipmentPolicy
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
        return $user->isAuthorized('shipments', Role::UT_READ);
    }

    /**
     * Determine whether the user can view the shipment.
     *
     * @param  \App\User $user
     * @param  \App\Shipment $shipment
     * @return boolean
     */
    public function view(User $user, Shipment $shipment)
    {
        return $user->client->account_number == $shipment->account_number ?? false;
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
     * @param  \App\Shipment $shipment
     * @return mixed
     */
    public function update(User $user, Shipment $shipment)
    {
        return $user->isAuthorized('shipments', Role::UT_UPDATE)
            && $user->client->account_number == $shipment->client_account_number;
    }

    /**
     * Determine whether the user can delete the shipment.
     *
     * @param  \App\User $user
     * @param  \App\Shipment $shipment
     * @return mixed
     */
    public function delete(User $user, Shipment $shipment)
    {
        return $user->isAuthorized('shipments', Role::UT_DELETE);
    }
}
