<?php

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


Route::prefix('admin')
->name('admin.')
->namespace('Admin')
->middleware(['auth', 'role:admin'])
->group(function () {
    Route::resource('vehicles', 'AdminVehicleController');
    Route::resource('alerts', 'AdminAlertController');
    Route::resource('operations', 'AdminOperationController');
    Route::resource('garages', 'AdminGarageController');
    Route::resource('maintenance-plans', 'AdminMaintenancePlanController');
    Route::resource('maintenance-operations', 'AdminMaintenanceOperationController')->only(['update', 'destroy']);
});


Route::prefix('fleet')
->name('fleet.')
->namespace('Fleet')
->middleware(['auth', 'role:fleet'])
->group(function () {
    Route::resource('operations', 'FleetOperationController');
});


Route::prefix('garage')
->name('garage.')
->namespace('Garage')
->middleware(['auth', 'role:garage'])
->group(function () {
    Route::resource('operations', 'GarageOperationController');
});
