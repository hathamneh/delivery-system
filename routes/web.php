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
    Route::get('shipments/create/{type?}', "ShipmentController@create")
        ->name('shipments.create')
        ->where('type', 'wizard|legacy');
    Route::resource('shipments', "ShipmentController")->except(['create']);

    Route::resource('zones', "ZoneController");
    Route::resource('zones/{zone}/address', "AddressController");

    Route::resource('users/roles', "UserTemplatesController");
    Route::resource('users', "UsersController");

    Route::resource('clients', "ClientsController");
    Route::resource('couriers', "CouriersController");
    Route::resource('pickups', "PickupsController");
});

// Localization
Route::get('/js/lang.js', function () {
    //$strings = Cache::rememberForever('lang.js', function () {
    $lang = config('app.locale');

    $files = glob(resource_path('lang/' . $lang . '/*.php'));
    $strings = [];

    foreach ($files as $file) {
        $name = basename($file, '.php');
        $strings[$name] = require $file;
    }

    //return $strings;
    //});

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');
    echo('window.trans = function(text){return window.i18n[text];}');
    exit();
})->name('assets.lang');