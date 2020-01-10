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

Route::get('/login', 'Auth\LoginController@form')->name('login');
Route::post('/login', 'Auth\LoginController@authenticate')->name('auth.authenticate');
Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');

// Route::get('/admin', 'Admin\AdminOperationController@index')->name('admin.home');
// Route::get('/garage', 'Garage\GarageOperationController@index')->name('garage.home');
// Route::get('/fleet', 'Fleet\FleetOperationController@index')->name('fleet.home');


Route::prefix('admin')
->name('admin.')
->namespace('Admin')
->middleware(['auth', 'role:admin'])
->group(function () {
    Route::resource('users', 'AdminUserController');
    Route::resource('families', 'AdminFamilyController');
    Route::resource('families.subfamilies', 'AdminSubfamilyController');
    Route::resource('vehicles', 'AdminVehicleController');
    Route::resource('alerts', 'AdminAlertController');
    Route::resource('fleets', 'AdminFleetController');
    Route::resource('garages', 'AdminGarageController');
    Route::resource('operations', 'AdminOperationController');
    Route::resource('repair-orders', 'AdminRepairOrdersController');
    Route::resource('maintenance-plans', 'AdminMaintenancePlanController');
    Route::resource('maintenance-plans.operations', 'AdminMaintenancePlanOperationController')->only(['index', 'store', 'destroy']);
    Route::get('maintenance-plans/{plan_id}/operations/search', 'AdminMaintenancePlanOperationController@search')->name('maintenance-plans.operations.search');
});


// Route::prefix('fleet')
// ->name('fleet.')
// ->namespace('Fleet')
// ->middleware(['auth', 'role:fleet'])
// ->group(function () {
//     Route::resource('operations', 'FleetOperationController');
// });


// Route::prefix('garage')
// ->name('garage.')
// ->namespace('Garage')
// ->middleware(['auth', 'role:garage'])
// ->group(function () {
//     Route::resource('operations', 'GarageOperationController');
//     Route::post('operations/{operation}/finish', 'GarageOperationController@finish')->name('operations.finish');
// });
