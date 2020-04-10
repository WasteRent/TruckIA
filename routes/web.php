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
Route::get('/', 'Auth\HomeController@index');

Route::get('/admin', 'Admin\AdminDashboardController@index')->name('admin.home');
Route::get('/garage', 'Garage\GarageRepairOrdersController@index')->name('garage.home');
Route::get('/customer', 'Customer\CustomerVehiclesController@index')->name('customer.home');
Route::get('/fleet', 'Fleet\FleetVehicleController@index')->name('fleet.home');


Route::get('/set-garage/{id}', function ($id) {
    session(['garage' => App\Models\Garage::findOrFail($id)]);
    return back();
});
Route::get('/set-vehicle/{id}', function ($id) {
    session(['vehicle' => App\Models\Vehicle::findOrFail($id)]);
    return back();
});


Route::prefix('admin')
->name('admin.')
->namespace('Admin')
->middleware(['auth', 'user-active', 'role:admin'])
->group(function () {
    Route::resource('users', 'AdminUserController');
    Route::resource('feedbacks', 'AdminFeedbackController')->only(['index', 'update']);
    Route::resource('families', 'AdminFamilyController');
    Route::resource('families.subfamilies', 'AdminSubfamilyController');
    Route::resource('fleets', 'AdminFleetController');
    Route::resource('operations', 'AdminOperationController');
    Route::resource('spare-parts', 'AdminSparePartController');

    Route::get('operations/{operation_id}/spare-parts/search', 'AdminOperationSparePartController@search')->name('operations.spare-parts.search');
    Route::resource('operations.spare-parts', 'AdminOperationSparePartController');

    Route::resource('maintenance-plans', 'AdminMaintenancePlanController');
    Route::resource('maintenance-plans.operations', 'AdminMaintenancePlanOperationController')->only(['index', 'store', 'destroy']);
    Route::get('maintenance-plans/{plan_id}/operations/search', 'AdminMaintenancePlanOperationController@search')->name('maintenance-plans.operations.search');
});



Route::prefix('garage')
->name('garage.')
->namespace('Garage')
->middleware(['auth', 'user-active', 'role:garage'])
->group(function () {
    Route::put('appointments/{appointment}/vehicle', 'GarageAppointmentController@vehicleReceived')->name('appointments.vehicle-received');
    Route::resource('appointments', 'GarageAppointmentController');
    Route::resource('alerts', 'GarageAlertController')->only(['index', 'update']);
    Route::resource('vehicles', 'GarageVehiclesController')->only(['index', 'show']);
    Route::get('details', 'GarageDetailsController@index')->name('details.index');
    Route::put('details', 'GarageDetailsController@update')->name('details.update');

    Route::resource('repair-orders', 'GarageRepairOrdersController')->only(['index', 'show', 'create', 'store']);
    Route::resource('repair-orders.operations', 'GarageRepairOrderOperationController')->only(['index','store', 'destroy']);
    Route::resource('repair-orders.maintenance-plans', 'GarageRepairOrderMaintenancePlanController')->only(['index', 'store']);
    Route::get('repair-orders/{repair_order}/vehicle', 'GarageRepairOrdersController@vehicle')->name('repair-orders.vehicle');
    Route::get('repair-orders/{repair_order}/garage', 'GarageRepairOrdersController@garage')->name('repair-orders.garage');
    Route::get('repair-orders/{repair_order}/authorization', 'GarageRepairOrdersController@authorization')->name('repair-orders.authorization');
    Route::post('repair-orders/{repair_order}/authorize', 'GarageRepairOrdersController@authorizeRepairOrder')->name('repair-orders.authorize');

    Route::get('repair-orders/{repair_order}/operations/{operation}/execute', 'GarageExecuteOperationController@show')->name('show.operation');
    Route::post('repair-orders/{repair_order}/operations/{operation}/execute', 'GarageExecuteOperationController@store')->name('execute.operation');
});


Route::prefix('customer')
->name('customer.')
->namespace('Customer')
->middleware(['auth', 'user-active', 'role:customer'])
->group(function () {
    Route::resource('preventives', 'CustomerPreventiveController')->only(['index', 'show']);
    Route::resource('preventives.operations', 'CustomerPreventiveOperationController')->only(['update']);
    Route::resource('appointments', 'CustomerAppointmentController')->only(['index']);
    Route::resource('vehicles', 'CustomerVehiclesController')->only(['index', 'show']);
    Route::resource('alerts', 'CustomerAlertController')->only(['index', 'update']);
    Route::resource('vehicles.failures', 'CustomerVehicleFailureController')->only(['index', 'create', 'store']);

    Route::get('details', 'CustomerDetailsController@index')->name('details.index');
    Route::put('details', 'CustomerDetailsController@update')->name('details.update');

    Route::get('vehicle/{vehicle}/tyre-failure', 'CustomerTyreFailureController@create')->name('tyre-failure.create');
    Route::post('vehicle/{vehicle}/tyre-failure', 'CustomerTyreFailureController@store')->name('tyre-failure.store');
});


Route::prefix('fleet')
->name('fleet.')
->namespace('Fleet')
->middleware(['auth', 'user-active', 'role:fleet'])
->group(function () {
    Route::get('details', 'FleetDetailsController@index')->name('details.index');
    Route::put('details', 'FleetDetailsController@update')->name('details.update');
    Route::resource('enterprise-groups', 'FleetEnterpriseGroupController');
    Route::resource('manufacturers', 'FleetManufacturerController');
    Route::resource('manufacturers.models', 'FleetManufacturerModelController');
    Route::resource('alerts', 'FleetAlertController')->only(['index', 'update']);
    Route::resource('garage.specialities', 'FleetGarageSpecialitiesController')->only(['index', 'update']);
    Route::resource('garages', 'FleetGarageController');
    Route::resource('customers', 'FleetCustomerController');
    Route::resource('customers.garages', 'FleetCustomerGarageController');

    Route::resource('vehicles', 'FleetVehicleController');
    Route::resource('vehicles.equipments', 'FleetVehicleEquipmentController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('vehicles.files', 'FleetVehicleFileController')->only(['index', 'store', 'destroy']);
    Route::resource('vehicles.pictures', 'FleetVehiclePictureController')->only(['index', 'store', 'destroy']);
    Route::resource('vehicles.customers', 'FleetVehicleCustomerController')->only(['store', 'index', 'destroy']);
    Route::resource('vehicles.notes', 'FleetVehicleNoteController')->only(['index', 'store', 'update', 'destroy']);


    Route::resource('repair-orders', 'FleetRepairOrdersController')->only(['index', 'show', 'create', 'store']);
    Route::resource('repair-orders.operations', 'FleetRepairOrderOperationController')->only(['index', 'store', 'destroy']);
    Route::resource('repair-orders.maintenance-plans', 'FleetRepairOrderMaintenancePlanController')->only(['index', 'store']);
    Route::get('repair-orders/{repair_order}/vehicle', 'FleetRepairOrdersController@vehicle')->name('repair-orders.vehicle');
    Route::get('repair-orders/{repair_order}/garage', 'FleetRepairOrdersController@garage')->name('repair-orders.garage');
    Route::put('repair-orders/{repair_order}/cancel', 'FleetRepairOrdersController@cancel')->name('repair-orders.cancel');
    Route::get('repair-orders/{repair_order}/authorization', 'FleetRepairOrdersController@authorization')->name('repair-orders.authorization');
    Route::post('repair-orders/{repair_order}/authorize', 'FleetRepairOrdersController@authorizeRepairOrder')->name('repair-orders.authorize');
});


Route::prefix('auth')
->name('auth.')
->namespace('Auth')
->middleware(['auth', 'user-active'])
->group(function () {
    Route::get('profile', 'AuthProfileController@index')->name('profile.index');
    Route::put('profile', 'AuthProfileController@update')->name('profile.update');
});


Auth::routes();
