<?php

use App\Form;
use App\Zone;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push(trans('common.home'), route('home'));
});
Breadcrumbs::for('shipments', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('shipment.label'), route('shipments.index'));
});
Breadcrumbs::for('shipments.create', function ($trail) {
    $trail->parent('shipments');
    $trail->push(trans('shipment.new'), route('shipments.create'));
});
Breadcrumbs::for('shipments.show', function ($trail, $shipment) {
    $trail->parent('shipments');
    $trail->push(trans('shipment.single') . ": " . $shipment->waybill,
        route('shipments.show', ['shipment' => $shipment->id]));
});


Breadcrumbs::for('zones', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('zone.label'), route('zones.index'));
});
Breadcrumbs::for('zones.create', function ($trail) {
    $trail->parent('zones');
    $trail->push(trans('zone.new'), route('zones.create'));
});
Breadcrumbs::for('zones.edit', function ($trail, Zone $zone) {
    $trail->parent('zones');
    $trail->push($zone->name, route('zones.edit', ['zone' => $zone]));
});

Breadcrumbs::for('addresses.edit', function ($trail, $zone, $address_id) {
    $trail->parent('zones.edit', $zone);
    $trail->push(trans('zone.address.edit'), route('address.edit', ['zone' => $zone, 'address' => $address_id]));
});

Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('user.label'), route('users.index'));
});
Breadcrumbs::for('users.create', function ($trail) {
    $trail->parent('users');
    $trail->push(trans('user.new'), route('users.create'));
});
Breadcrumbs::for('users.edit', function ($trail, $user_id) {
    $trail->parent('users');
    $trail->push(trans('user.edit'), route('users.edit', ['user' => $user_id]));
});


Breadcrumbs::for('roles', function ($trail) {
    $trail->parent('users');
    $trail->push(trans('user.roles.label'), route('roles.index'));
});
Breadcrumbs::for('roles.create', function ($trail) {
    $trail->parent('roles');
    $trail->push(trans('user.roles.add_new'), route('roles.create'));
});
Breadcrumbs::for('roles.edit', function ($trail, $role_id) {
    $trail->parent('roles');
    $trail->push(trans('user.roles.edit'), route('roles.edit', ['role' => $role_id]));
});


Breadcrumbs::for('clients', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('client.label'), route('clients.index'));
});
Breadcrumbs::for('clients.create', function ($trail) {
    $trail->parent('clients');
    $trail->push(trans('client.create'), route('clients.create'));
});
Breadcrumbs::for('clients.show', function ($trail, \App\Client $client) {
    $trail->parent('clients');
    $trail->push($client->trade_name, route('clients.show', [$client]));
});

Breadcrumbs::for('couriers', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('courier.label'), route('couriers.index'));
});
Breadcrumbs::for('couriers.create', function ($trail) {
    $trail->parent('couriers');
    $trail->push(trans('courier.create'), route('couriers.create'));
});
Breadcrumbs::for('couriers.show', function ($trail, \App\Courier $courier) {
    $trail->parent('couriers');
    $trail->push($courier->name, route('couriers.show', [$courier]));
});

Breadcrumbs::for('couriers.edit', function ($trail, \App\Courier $courier) {
    $trail->parent('couriers');
    $trail->push($courier->name, route('couriers.edit', [$courier]));
});


Breadcrumbs::for('pickups', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('pickup.label'), route('pickups.index'));
});
Breadcrumbs::for('pickups.create', function ($trail) {
    $trail->parent('pickups');
    $trail->push(trans('pickup.create'), route('pickups.create'));
});
Breadcrumbs::for('pickups.edit', function ($trail, $pid) {
    $trail->parent('pickups');
    $trail->push(trans('pickup.edit'), route('pickups.edit', ['pickup' => $pid]));
});


Breadcrumbs::for('settings', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('settings.label'), route('settings.index'));
});
Breadcrumbs::for('emails.index', function ($trail) {
    $trail->parent('settings');
    $trail->push(trans('emails.label'), route('emails.index'));
});

Breadcrumbs::for('notes', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('note.label'), route('notes.index'));
});

Breadcrumbs::for('services', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('service.label'), route('services.index'));
});
Breadcrumbs::for('services.create', function ($trail) {
    $trail->parent('services');
    $trail->push(trans('service.create'), route('services.create'));
});
Breadcrumbs::for('services.edit', function ($trail, $service) {
    $trail->parent('services');
    $trail->push(trans('service.edit'), route('services.edit', [$service]));
});


Breadcrumbs::for('reports', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('reports.label'), route('reports.index'));
});

Breadcrumbs::for('accounting', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('accounting.label'), route('accounting.index'));
});
Breadcrumbs::for('accounting.invoice', function ($trail, \App\Invoice $invoice) {
    $trail->parent('home');
    $trail->push(trans('accounting.invoice'), route('accounting.invoice', [$invoice]));
});
Breadcrumbs::for('inventory.index', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('inventory.today'), route('inventory.index'));
});

Breadcrumbs::for('inventory.couriers', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('inventory.couriers'), route('inventory.courier'));
});


Breadcrumbs::for('forms', function($trail) {
    $trail->parent('home');
    $trail->push(trans('forms.label'), route('forms.index'));
});
Breadcrumbs::for('forms.create', function($trail) {
    $trail->parent('forms');
    $trail->push(trans('forms.create'), route('forms.create'));
});
Breadcrumbs::for('forms.edit', function($trail, Form $form) {
    $trail->parent('forms');
    $trail->push(trans('forms.edit'), route('forms.edit', [$form]));
});