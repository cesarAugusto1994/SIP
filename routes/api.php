<?php

use Illuminate\Http\Request;

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
/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
/*
Route::middleware('auth:api')->group(function() {
    Route::get('/user', 'Api\UserController@index')->name('api_user_index');
    Route::get('/user/{id}', 'Api\UserController@show')->name('api_user_show');
});
*/



Route::prefix('v1')->group(function() {
  Route::get('/user', 'Api\UserController@index')->name('api_user_index');
  Route::get('/user/{id}', 'Api\UserController@show')->name('api_user_show');
  Route::get('/tickets', 'Api\TicketController@index')->name('api_tickets_index');
  Route::get('/deliveries', 'Api\DeliveryController@index')->name('api_deliveries_index');
  Route::get('/delivery/{id}', 'Api\DeliveryController@show')->name('api_deliveries_show');
  Route::put('user/{user}/online', 'UserOnlineController');
  Route::put('user/{user}/offline', 'UserOfflineController');
});
/*
Route::prefix('v1')->group(function() {

  Route::get("/delivery-order/{id}", 'DeliveryOrderController@delivery');

});
*/
