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

Route::get('/home', 'Auth\HomeController@index');

Route::get('/admin', 'Admin\AdminOperationController@index')->name('admin.home');
Route::get('/garage', 'Garage\GarageRepairOrdersController@index')->name('garage.home');
Route::get('/customer', 'Customer\CustomerVehiclesController@index')->name('customer.home');
Route::get('/fleet', 'Fleet\FleetVehiclesController@index')->name('fleet.home');


Route::prefix('admin')
->name('admin.')
->namespace('Admin')
->middleware(['auth', 'user-active', 'role:admin'])
->group(function () {
    Route::resource('users', 'AdminUserController');
    Route::resource('feedbacks', 'AdminFeedbackController')->only(['index', 'update']);
    Route::resource('customers', 'AdminCustomerController');
    Route::resource('enterprise-groups', 'AdminEnterpriseGroupController');
    Route::resource('vehicles.customers', 'AdminVehicleCustomerController');
    Route::resource('manufacturers', 'AdminManufacturerController');
    Route::resource('manufacturers.models', 'AdminManufacturerModelController');
    Route::resource('families', 'AdminFamilyController');
    Route::resource('families.subfamilies', 'AdminSubfamilyController');
    Route::resource('vehicles', 'AdminVehicleController');
    Route::resource('vehicles.garages', 'AdminVehicleGarageController');
    Route::resource('garage.specialities', 'AdminGarageSpecialitiesController')->only(['index', 'update']);
    Route::resource('alerts', 'AdminAlertController')->only(['index']);
    Route::resource('fleets', 'AdminFleetController');
    Route::resource('garages', 'AdminGarageController');
    Route::resource('operations', 'AdminOperationController');
    Route::resource('spare-parts', 'AdminSparePartController');

    Route::get('operations/{operation_id}/spare-parts/search', 'AdminOperationSparePartController@search')->name('operations.spare-parts.search');
    Route::resource('operations.spare-parts', 'AdminOperationSparePartController');

    Route::get('repair-orders/{repair_order}/authorization', 'AdminRepairOrdersController@authorization')->name('repair-orders.authorization');
    Route::post('repair-orders/{repair_order}/authorize', 'AdminRepairOrdersController@authorizeRepairOrder')->name('repair-orders.authorize');
    Route::resource('repair-orders', 'AdminRepairOrdersController')->only(['index', 'show', 'create']);

    // Route::resource('repair-orders.vehicles', 'AdminRepairOrderVehicleController')->only(['create', 'edit', 'update', 'store']);
    // Route::resource('repair-orders.garages', 'AdminRepairOrderGarageController')->only(['create', 'edit', 'update', 'store']);
    // Route::resource('repair-orders.operations', 'AdminRepairOrderOperationController')->only(['index', 'store', 'destroy']);


    Route::resource('maintenance-plans', 'AdminMaintenancePlanController');
    Route::resource('maintenance-plans.operations', 'AdminMaintenancePlanOperationController')->only(['index', 'store', 'destroy']);
    Route::get('maintenance-plans/{plan_id}/operations/search', 'AdminMaintenancePlanOperationController@search')->name('maintenance-plans.operations.search');
});

Route::prefix('customer')
->name('customer.')
->namespace('Customer')
->middleware(['auth', 'user-active', 'role:customer'])
->group(function () {
    Route::resource('vehicles', 'CustomerVehiclesController')->only(['index', 'show']);
    Route::resource('alerts', 'CustomerAlertController')->only(['index']);

    Route::get('details', 'CustomerDetailsController@index')->name('details.index');
    Route::put('details', 'CustomerDetailsController@update')->name('details.update');
});


Route::prefix('fleet')
->name('fleet.')
->namespace('Fleet')
->middleware(['auth', 'user-active', 'role:fleet'])
->group(function () {
    Route::resource('vehicles', 'FleetVehiclesController')->only(['index', 'show']);
    Route::resource('alerts', 'FleetAlertController')->only(['index']);

    Route::get('details', 'FleetDetailsController@index')->name('details.index');
    Route::put('details', 'FleetDetailsController@update')->name('details.update');
});


Route::prefix('garage')
->name('garage.')
->namespace('Garage')
->middleware(['auth', 'user-active', 'role:garage'])
->group(function () {
    Route::resource('alerts', 'GarageAlertController')->only(['index']);
    Route::resource('vehicles', 'GarageVehiclesController')->only(['index', 'show']);
    Route::get('details', 'GarageDetailsController@index')->name('details.index');
    Route::put('details', 'GarageDetailsController@update')->name('details.update');

    Route::get('repair-orders/{repair_order}/authorization', 'GarageRepairOrdersController@authorization')->name('repair-orders.authorization');
    Route::post('repair-orders/{repair_order}/authorize', 'GarageRepairOrdersController@authorizeRepairOrder')->name('repair-orders.authorize');
    Route::resource('repair-orders', 'GarageRepairOrdersController')->only(['index', 'show', 'create']);
    Route::resource('repair-orders.vehicles', 'GarageRepairOrderVehicleController')->only(['create', 'store']);
    Route::resource('repair-orders.operations', 'GarageRepairOrderOperationController')->only(['index','store', 'destroy']);

    Route::get('repair-orders/{repair_order}/operations/{operation}/execute', 'GarageExecuteOperationController@show')->name('show.operation');
    Route::post('repair-orders/{repair_order}/operations/{operation}/execute', 'GarageExecuteOperationController@store')->name('execute.operation');
});

Auth::routes();
