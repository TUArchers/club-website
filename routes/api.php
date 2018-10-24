<?php

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

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');

Route::post('/contact', 'PublicPages\ContactController@postContact')->name('api.contact');

Route::post('/tasters/{eventId}/reservations', 'Kiosk\TastersController@storeReservation');
Route::put('/tasters/{eventId}/reservations/{reservationId}', 'Kiosk\TastersController@updateReservation');

Route::post('/events/{eventId}/reservations', 'Kiosk\EventsController@storeReservation');
Route::put('/events/{eventId}/reservations/{reservationId}', 'Kiosk\EventsController@updateReservation');
Route::patch('/events/{eventId}/reservations/{reservationId}', 'Admin\EventsController@markReservation')->name('api.reservation.patch');