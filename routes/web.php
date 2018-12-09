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

    \App\Shipment::routes();

    \App\Zone::routes();

    \App\User::routes();

    \App\Client::routes();

    \App\Attachment::routes();

    \App\Courier::routes();

    \App\Pickup::routes();

    \App\Service::routes();

    \App\Note::routes();

    \App\Invoice::routes();

    \App\Form::routes();

    Route::get('reports', "ReportingController@index")->name('reports.index');
    Route::put('reports', "ReportingController@update")->name('reports.update');

    Route::resource('settings', "SettingsController");
    Route::get('emails', "MailingController@index")->name('emails.index');

    Route::prefix('ajax')->group(function () {
        Route::get('notifications/all', 'NotificationsController@index');
        Route::get('notifications/refresh', 'NotificationsController@refresh');
        Route::get('notifications/clear', 'NotificationsController@clear');
    });

});
