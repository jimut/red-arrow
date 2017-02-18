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

// FCM Token Registration
Route::get('/fcm/register/{token}', 'API\FCMTokenController@register');
Route::get('/fcm/revoke/{token}', 'API\FCMTokenController@revoke');

// User
Route::get('/user', [
    'as' => 'api.user.show',
    'uses' => 'API\UserController@show'
]);
Route::get('user/donation', [
    'as' => 'api.user.donation',
    'uses' => 'API\UserController@donation'
]);

// Donor
Route::get('notification', 'API\AppointmentController@received');
Route::resource('donor', 'API\DonorController', ['names' => [
    'index'   => 'api.donor.index',
    'show'    => 'api.donor.show',
    'create'  => 'api.donor.create',
    'store'   => 'api.donor.store',
    'edit'    => 'api.donor.edit',
    'update'  => 'api.donor.update',
    'destroy' => 'api.donor.destroy'
]]);

// Hospital
Route::resource('hospital', 'API\HospitalController', ['names' => [
    'index'   => 'api.hospital.index',
    'show'    => 'api.hospital.show',
    'create'  => 'api.hospital.create',
    'store'   => 'api.hospital.store',
    'edit'    => 'api.hospital.edit',
    'update'  => 'api.hospital.update',
    'destroy' => 'api.hospital.destroy'
]]);

// Appointment
Route::post('appointment', [
    'as' => 'api.appointment.store',
    'uses' => 'API\AppointmentController@store'
]);
Route::get('appointment/sent', [
    'as' => 'api.appointment.sent',
    'uses' => 'API\AppointmentController@sent'
]);
Route::get('appointment/received', [
    'as' => 'api.appointment.received',
    'uses' => 'API\AppointmentController@received'
]);
Route::get('appointment/accepted', [
    'as' => 'api.appointment.accepted',
    'uses' => 'API\AppointmentController@accepted'
]);
Route::get('appointment/approved', [
    'as' => 'api.appointment.approved',
    'uses' => 'API\AppointmentController@approved'
]);
Route::get('appointment/{appointment}/accept', [
    'as' => 'api.appointment.accept',
    'uses' => 'API\AppointmentController@accept'
]);
Route::get('appointment/{appointment}/reject', [
    'as' => 'api.appointment.reject',
    'uses' => 'API\AppointmentController@reject'
]);
Route::get('appointment/{appointment}/approve', [
    'as' => 'api.appointment.approve',
    'uses' => 'API\AppointmentController@approve'
]);

// Review
Route::get('appointment/{appointment}/review', [
    'as' => 'api.appointment.review.show',
    'uses' => 'API\ReviewController@show'
]);
Route::post('appointment/{appointment}/review', [
    'as' => 'api.appointment.review.store',
    'uses' => 'API\ReviewController@store'
]);
