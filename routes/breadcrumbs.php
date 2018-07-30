<?php

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
Breadcrumbs::for('zones.edit', function ($trail, $zone_id) {
    $trail->parent('zones');
    $trail->push(trans('zone.edit'), route('zones.edit', ['zone' => $zone_id]));
});

Breadcrumbs::for('addresses.edit', function ($trail, $zone_id, $address_id) {
    $trail->parent('zones.edit', $zone_id);
    $trail->push(trans('zone.address.edit'), route('address.edit', ['zone' => $zone_id, 'address' => $address_id]));
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


Breadcrumbs::for('couriers', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('courier.label'), route('couriers.index'));
});
Breadcrumbs::for('couriers.create', function ($trail) {
    $trail->parent('couriers');
    $trail->push(trans('courier.create'), route('couriers.create'));
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

Breadcrumbs::for('notes', function ($trail) {
    $trail->parent('home');
    $trail->push(trans('note.label'), route('notes.index'));
});