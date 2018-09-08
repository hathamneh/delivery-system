<?php

namespace App\Providers;

use App\Policies\PickupPolicy;
use App\Policies\NotePolicy;
use App\Policies\ShipmentPolicy;
use App\Policies\ClientPolicy;
use App\Policies\CouriersPolicy;
use App\Policies\ZonePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        'App\Client' => ClientPolicy::class,
        'App\Courier' => CouriersPolicy::class,
        'App\Shipment' => ShipmentPolicy::class,
        'App\Pickup' => PickupPolicy::class,
        'App\Note' => NotePolicy::class,
        'App\Zone' => ZonePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    }
}
