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

Route::get('/user', function (Request $request) {
    $user = $request->user();
    $user->hospital;
    $user->donor;
    return $user->toArray();
})->middleware('auth:api');

Route::get('/fcm/register/{token}', 'API\FCMTokenController@register');
Route::get('/fcm/revoke/{token}', 'API\FCMTokenController@revoke');

Route::get('notification', 'API\DonorController@showNotification');
Route::resource('donor', 'API\DonorController', ['names' => [
    'index'   => 'api.donor.index',
    'show'    => 'api.donor.show',
    'create'  => 'api.donor.create',
    'store'   => 'api.donor.store',
    'edit'    => 'api.donor.edit',
    'update'  => 'api.donor.update',
    'destroy' => 'api.donor.destroy'
]]);
Route::resource('hospital', 'API\HospitalController', ['names' => [
    'index'   => 'api.hospital.index',
    'show'    => 'api.hospital.show',
    'create'  => 'api.hospital.create',
    'store'   => 'api.hospital.store',
    'edit'    => 'api.hospital.edit',
    'update'  => 'api.hospital.update',
    'destroy' => 'api.hospital.destroy'
]]);
Route::post('appointment', 'API\AppointmentController@store');
