<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function($trail){
    $trail->push(trans('base.home'), route('home'));
});
Breadcrumbs::for('shipments', function($trail){
    $trail->parent('home');
    $trail->push(trans('shipment.label'), route('shipments.index'));
});

Breadcrumbs::for('shipments.create', function($trail){
    $trail->parent('shipments');
    $trail->push(trans('shipment.new'), route('shipments.create'));
});


Breadcrumbs::for('zones', function($trail){
    $trail->parent('home');
    $trail->push(trans('zone.label'), route('zones.index'));
});
Breadcrumbs::for('zones.create', function($trail){
    $trail->parent('zones');
    $trail->push(trans('zone.new'), route('zones.create'));
});
Breadcrumbs::for('zones.edit', function($trail, $zone_id){
    $trail->parent('zones');
    $trail->push(trans('zone.edit'), route('zones.edit', ['zone' => $zone_id]));
});