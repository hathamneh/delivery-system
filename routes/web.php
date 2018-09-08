<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('tracking', "TrackController@show")->name('tracking.show');
Route::middleware('auth')->group(function () {

    Route::get('shipments/returned', "ShipmentController@returned")->name('shipments.returned');
    Route::get('shipments/create/{type?}', "ShipmentController@create")
        ->name('shipments.create')
        ->where('type', 'wizard|legacy');
    Route::get('shipments/{shipment}/{tab?}', "ShipmentController@show")
        ->name('shipments.show')
        ->where('tab', 'summery|details|actions|status');
    Route::resource('shipments', "ShipmentController")->except(['create', 'show']);

    Route::put('shipments/{shipment}/return', "ShipmentController@makeReturn")->name('shipments.return');

    Route::resource('zones', "ZoneController");
    Route::resource('zones/{zone}/address', "AddressController");

    Route::resource('users/roles', "UserTemplatesController");
    Route::resource('users', "UsersController");

    Route::get('clients/create', "ClientsController@create")->name('clients.create');
    Route::get('clients/{client}/edit/{section?}', "ClientsController@edit")->name('clients.edit');
    Route::resource('clients', "ClientsController")->except(['show', 'create', 'edit']);

    Route::post('clients/{client}/zones', "ClientZonesController@store")->name('clients.zones.store');
    Route::get('clients/{client}/zones', "ClientZonesController@index")->name('clients.zones.index');
    Route::get('clients/{client}/zones/{zone}', "ClientZonesController@show")->name('clients.zones.show');
    Route::put('clients/{client}/zones/{zone}', "ClientZonesController@update")->name('clients.zones.update');
    Route::delete('clients/{client}/zones/{zone}', "ClientZonesController@destroy")->name('clients.zones.destroy');

    Route::put('clients/{client}/addresses/{address}', "CustomAddressesController@update")->name('clients.addresses.update');
    Route::post('clients/{client}/addresses', "CustomAddressesController@store")->name('clients.addresses.store');
    Route::post('clients/{client}/addresses/bulk', "CustomAddressesController@bulk")->name('clients.addresses.bulk');
    Route::get('clients/{client}/zones/{zone}/addresses', "CustomAddressesController@index")->name('clients.addresses.index');
    Route::delete('clients/{client}/addresses', "CustomAddressesController@bulkDestroy")->name('clients.addresses.bulkDestroy');
    Route::delete('clients/{client}/addresses/{address}', "CustomAddressesController@destroy")->name('clients.addresses.destroy');

    Route::get('clients/{client}/{tab?}', "ClientsController@show")
        ->name('clients.show')
        ->where('tab', 'statistics|shipments|pickups');

    Route::delete('attachment/{attachment}', "AttachmentController@destroy")->name('attachment.destroy');

    Route::resource('couriers', "CouriersController");
    Route::resource('pickups', "PickupsController");
    Route::resource('notes', "NotesController");
    Route::resource('services', "ServicesController");

    Route::get('reports', "ReportingController@index")->name('reports.index');
    Route::put('reports', "ReportingController@update")->name('reports.update');

    Route::get('accounting', "AccountingController@index")->name('accounting.index');
    Route::post('accounting/invoice', "AccountingController@store")->name('accounting.store');
    Route::get('accounting/invoice/{invoice}', "AccountingController@show")->name('accounting.invoice');
    Route::get('accounting/goto', "AccountingController@goto")->name('accounting.goto');

    Route::resource('settings', "SettingsController");
    Route::get('emails', "MailingController@index")->name('emails.index');
});


function parseItems($key, $value)
{

    array_walk($test_array, function (&$a, $b) {
        $a = "$b loves $a";
    });
}