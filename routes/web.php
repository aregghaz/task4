09<?php

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

Route::get('/', function () {
    return view('welcome');
});

    Route::resource('users', 'UserController');
    Route::get('users/showById/{id}', 'UserController@showById');
    Route::post('register', 'UserController@register');
    Route::put('users/update/{id}', 'UserController@update');
    Route::delete('users/destroy/{id}', 'UserController@destroy');

