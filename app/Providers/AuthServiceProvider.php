<?php

namespace App\Providers;

use App\Client;
use App\Courier;
use App\Form;
use App\Note;
use App\Pickup;
use App\Policies\FormPolicy;
use App\Policies\PickupPolicy;
use App\Policies\NotePolicy;
use App\Policies\ServicePolicy;
use App\Policies\ShipmentPolicy;
use App\Policies\ClientPolicy;
use App\Policies\CouriersPolicy;
use App\Policies\ZonePolicy;
use App\Service;
use App\Shipment;
use App\Zone;
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
        Client::class => ClientPolicy::class,
        Courier::class => CouriersPolicy::class,
        Shipment::class => ShipmentPolicy::class,
        Pickup::class => PickupPolicy::class,
        Note::class => NotePolicy::class,
        Zone::class => ZonePolicy::class,
        Service::class => ServicePolicy::class,
        Form::class => FormPolicy::class,
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
