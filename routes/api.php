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

Route::post('/contacts', 'ContactController@store')->name('api.contacts.store');
Route::get('/contacts/{contact}', 'ContactController@show')->name('api.contact.show');
Route::patch('/contacts/{contact}', 'ContactController@update')->name('api.contact.update');
Route::delete('/contacts/{contact}', 'ContactController@destroy')->name('api.contact.destroy');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

