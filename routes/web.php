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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::resource('donor', 'DonorController');
Route::resource('hospital', 'HospitalController');

Route::get('find', [
    'as' => 'donor.find',
    'uses' => 'DonorController@find'
]);
