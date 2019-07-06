<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event'                 => [
            'App\Listeners\EventListener',
        ],
        \App\Events\PickupSaving::class    => [
            \App\Listeners\PickupSaving::class,
        ],
        \App\Events\PickupCreated::class   => [
            \App\Listeners\PickupCreated::class,
        ],
        \App\Events\ShipmentSaving::class  => [
            \App\Listeners\ShipmentSaving::class,
        ],
        \App\Events\ShipmentCreated::class => [
            \App\Listeners\ShipmentCreated::class,
        ],
        \App\Events\ShipmentDeleted::class => [
            \App\Listeners\ShipmentDeleted::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
