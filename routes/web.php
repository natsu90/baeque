<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/api/ticket/{activity_id}', 'TicketController@createTicket')->where('activity_id', '[0-9]+');
Route::get('/api/get_eta', 'TicketController@getTicketETA');
Route::get('/api/number', 'InterfaceController@number');
Route::get('/api/activites_get', 'TicketController@listActivity');

Route::get('/api/counter/queue/{counter_id}', 'CounterController@listCounterAction')->where('counter_id', '[0-9]+');

Route::get('/api/counter/{counter_id}/{ticket_id}', 'CounterController@pickTicketToCounter')->where('counter_id', '[0-9]+')->where('ticket_id', '[0-9]+');

Route::get('/kiosk', 'KioskController@index');