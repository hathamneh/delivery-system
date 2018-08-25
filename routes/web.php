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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function() {
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
    Route::get('clients/{client}/{tab?}', "ClientsController@show")
        ->name('clients.show');
    Route::resource('clients', "ClientsController")->except(['show', 'create', 'edit']);

    Route::delete('attachment/{attachment}', "AttachmentController@destroy")->name('attachment.destroy');

    Route::resource('couriers', "CouriersController");
    Route::resource('pickups', "PickupsController");
    Route::resource('settings', "SettingsController");
    Route::resource('notes', "NotesController");
    Route::resource('services', "ServicesController");

    Route::get('reports', "ReportingController@index")->name('reports.index');
    Route::put('reports', "ReportingController@update")->name('reports.update');

    Route::get('accounting', "AccountingController@index")->name('accounting.index');
    Route::post('accounting/invoice', "AccountingController@store")->name('accounting.store');
    Route::get('accounting/invoice/{invoice}', "AccountingController@show")->name('accounting.invoice');
    Route::get('accounting/goto', "AccountingController@goto")->name('accounting.goto');
});

//test Routes
Route::group(['middleware'=> 'web'],function(){
  Route::resource('test','\App\Http\Controllers\TestController');
  Route::post('test/{id}/update','\App\Http\Controllers\TestController@update');
  Route::get('test/{id}/delete','\App\Http\Controllers\TestController@destroy');
  Route::get('test/{id}/deleteMsg','\App\Http\Controllers\TestController@DeleteMsg');
});


function parseItems($key, $value) {

    array_walk($test_array, function(&$a, $b) { $a = "$b loves $a"; });
}