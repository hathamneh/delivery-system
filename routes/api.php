<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('suggest/shipments', "Api\SuggestController@shipments");
Route::get('suggest/clients', "Api\SuggestController@clients");
Route::get('suggest/guest/{national_id}', "Api\SuggestController@guests");
Route::get('suggest/couriers', "Api\SuggestController@couriers");
Route::get('suggest/status/{status}', "Api\SuggestController@statuses");

// reports
//Route::middleware('auth:api')->group(function(){
    Route::get('reports/make', "ReportingController@makeReport")->name('api.reports.make');
//});