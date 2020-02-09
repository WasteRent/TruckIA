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

Route::get('/admin', 'Admin\AdminOperationController@index')->name('admin.home');
Route::get('/garage', 'Garage\GarageRepairOrdersController@index')->name('garage.home');
// Route::get('/fleet', 'Fleet\FleetOperationController@index')->name('fleet.home');


Route::prefix('admin')
->name('admin.')
->namespace('Admin')
->middleware(['auth', 'user-active', 'role:admin'])
->group(function () {
    Route::resource('users', 'AdminUserController');
    Route::resource('manufacturers', 'AdminManufacturerController');
    Route::resource('manufacturers.models', 'AdminManufacturerModelController');
    Route::resource('families', 'AdminFamilyController');
    Route::resource('families.subfamilies', 'AdminSubfamilyController');
    Route::resource('vehicles', 'AdminVehicleController');
    Route::resource('alerts', 'AdminAlertController');
    Route::resource('fleets', 'AdminFleetController');
    Route::resource('garages', 'AdminGarageController');
    Route::resource('operations', 'AdminOperationController');
    Route::resource('spare-parts', 'AdminSparePartController');

    Route::get('operations/{operation_id}/spare-parts/search', 'AdminOperationSparePartController@search')->name('operations.spare-parts.search');
    Route::resource('operations.spare-parts', 'AdminOperationSparePartController');

    Route::get('repair-orders/{repair_order}/authorization', 'AdminRepairOrdersController@authorization')->name('repair-orders.authorization');
    Route::post('repair-orders/{repair_order}/authorize', 'AdminRepairOrdersController@authorizeRepairOrder')->name('repair-orders.authorize');
    Route::resource('repair-orders', 'AdminRepairOrdersController')->only(['index', 'show', 'create']);

    Route::resource('repair-orders.vehicles', 'AdminRepairOrderVehicleController')->only(['create', 'edit', 'update', 'store']);
    Route::resource('repair-orders.garages', 'AdminRepairOrderGarageController')->only(['create', 'edit', 'update', 'store']);
    Route::resource('repair-orders.operations', 'AdminRepairOrderOperationController')->only(['index', 'store', 'destroy']);


    Route::resource('maintenance-plans', 'AdminMaintenancePlanController');
    Route::resource('maintenance-plans.operations', 'AdminMaintenancePlanOperationController')->only(['index', 'store', 'destroy']);
    Route::get('maintenance-plans/{plan_id}/operations/search', 'AdminMaintenancePlanOperationController@search')->name('maintenance-plans.operations.search');
});


// Route::prefix('fleet')
// ->name('fleet.')
// ->namespace('Fleet')
// ->middleware(['auth', 'user-active', 'role:fleet'])
// ->group(function () {
//     Route::resource('operations', 'FleetOperationController');
// });


Route::prefix('garage')
->name('garage.')
->namespace('Garage')
->middleware(['auth', 'user-active', 'role:garage'])
->group(function () {
    Route::resource('repair-orders', 'GarageRepairOrdersController')->only(['index', 'show']);
    Route::get('repair-orders/{repair_order}/operations/{operation}/execute', 'GarageExecuteOperationController@show')->name('show.operation');
    Route::post('repair-orders/{repair_order}/operations/{operation}/execute', 'GarageExecuteOperationController@store')->name('execute.operation');
});
