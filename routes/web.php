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

// Auth
Route::get('auth/activate/{token}', [
    'as' => 'user.activate',
    'uses' => 'Auth\ActivationController@activate'
]);
Route::get('auth/{provider}', 'Auth\SocialAuthController@redirect');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@callback');
Auth::routes();

// User
Route::get('user/donation', [
    'as' => 'user.donation',
    'uses' => 'UserController@donation'
]);

// Donor
Route::get('find', [
    'as' => 'donor.find',
    'uses' => 'DonorController@find'
]);
Route::get('notification', 'AppointmentController@received');
Route::resource('donor', 'DonorController');

// Hospital
Route::resource('hospital', 'HospitalController');

// Appointment
Route::post('appointment', [
    'as' => 'appointment.store',
    'uses' => 'AppointmentController@store'
]);
Route::get('appointment/sent', [
    'as' => 'appointment.sent',
    'uses' => 'AppointmentController@sent'
]);
Route::get('appointment/received', [
    'as' => 'appointment.received',
    'uses' => 'AppointmentController@received'
]);
Route::get('appointment/accepted', [
    'as' => 'appointment.accepted',
    'uses' => 'AppointmentController@accepted'
]);
Route::get('appointment/approved', [
    'as' => 'appointment.approved',
    'uses' => 'AppointmentController@approved'
]);
Route::get('appointment/{appointment}/accept', [
    'as' => 'appointment.accept',
    'uses' => 'AppointmentController@accept'
]);
Route::get('appointment/{appointment}/reject', [
    'as' => 'appointment.reject',
    'uses' => 'AppointmentController@reject'
]);
Route::get('appointment/{appointment}/approve', [
    'as' => 'appointment.approve',
    'uses' => 'AppointmentController@approve'
]);

// Review
Route::get('appointment/{appointment}/review', [
    'as' => 'appointment.review.show',
    'uses' => 'ReviewController@show'
]);
Route::post('appointment/{appointment}/review', [
    'as' => 'appointment.review.store',
    'uses' => 'ReviewController@store'
]);
Route::get('appointment/{appointment}/review/create', [
    'as' => 'appointment.review.create',
    'uses' => 'ReviewController@create'
]);
