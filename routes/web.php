<?php

use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\OperationFamily;
use Illuminate\Http\Request;

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

Route::post('/contact', 'ContactController@store');


Route::get('/home', 'Auth\HomeController@index');
Route::view('/', 'index');


Route::get('/set-garage/{id}', function (Request $request, $id) {
    session(['garage' => App\Models\Garage::findOrFail($id)]);
    session(['assigned_user_id' => $request->assigned_user_id]);
    return back();
});
Route::get('/set-vehicle/{id}', function ($id) {
    session(['vehicle' => App\Models\Vehicle::findOrFail($id)]);
    $previousUrl = app('url')->previous();
    return redirect(str_replace('vehicle_id', '', $previousUrl));
});


Route::prefix('admin')
->name('admin.')
->namespace('Admin')
->middleware(['auth', 'user-active', 'role:admin'])
->group(function () {
    Route::get('dashboard', 'AdminDashboardController@index')->name('home');

    Route::resource('users', 'AdminUserController');
    Route::resource('feedbacks', 'AdminFeedbackController')->only(['index', 'update']);
    Route::resource('families', 'AdminFamilyController');
    Route::resource('families.subfamilies', 'AdminSubfamilyController');
    Route::resource('fleets', 'AdminFleetController');
    Route::resource('spare-parts', 'AdminSparePartController');
    Route::resource('manufacturers', 'AdminManufacturerController');
    Route::resource('manufacturers.models', 'AdminManufacturerModelController');
    
    Route::get('models/{model}/handbooks', 'AdminModelHandbookController@index')->name('handbooks.index');
    Route::post('models/{model}/technical-handbook', 'AdminModelHandbookController@storeTechnical')->name('handbooks.technical.store');
    Route::delete('models/{model}/technical-handbook', 'AdminModelHandbookController@destroyTechnical')->name('handbooks.technical.destroy');
    Route::post('models/{model}/usage-handbook', 'AdminModelHandbookController@storeUsage')->name('handbooks.usage.store');
    Route::delete('models/{model}/usage-handbook', 'AdminModelHandbookController@destroyUsage')->name('handbooks.usage.destroy');

    Route::resource('universal-operations', 'AdminUniversalOperationController');

    Route::resource('operations.spare-parts', 'AdminOperationSparePartController');

    Route::get('maintenance-plan-operations/{operation}/spare-parts', 'AdminMaintenancePlanOperationSparePartController@index')->name('maintenance-plans-operation.spare-parts.index');
    Route::get('maintenance-plan-operations/{operation}/spare-parts/create', 'AdminMaintenancePlanOperationSparePartController@create')->name('maintenance-plans-operation.spare-parts.create');
    Route::post('maintenance-plan-operations/{operation}/spare-parts', 'AdminMaintenancePlanOperationSparePartController@store')->name('maintenance-plans-operation.spare-parts.store');

    Route::get('maintenance-plans/stats', 'AdminMaintenancePlanStatsController@index')->name('maintenance-plans.stats');
    
    Route::resource('maintenance-plans', 'AdminMaintenancePlanController');
    Route::post('/maintenance-plans/{plan}/clone', 'AdminMaintenancePlanController@clone')->name('maintenance-plans.clone');
    Route::resource('maintenance-plans.operations', 'AdminMaintenancePlanOperationController');

    Route::get('/maintenance-plans/{plan}/operations/{operation}/remove-image', 'AdminMaintenancePlanOperationController@removeImage')->name('maintenance-plans.removeImage');
});


Route::prefix('fleet')
->name('fleet.')
->namespace('Fleet')
->middleware(['auth', 'user-active', 'role:fleet'])
->group(function () {
    Route::get('dashboard', function () {
        return redirect()->route('fleet.dashboard.preventives');
    })->name('home');
    Route::get('dashboard/preventives', 'FleetDashboardController@preventives')->name('dashboard.preventives');
    Route::get('dashboard/itv', 'FleetDashboardController@itv')->name('dashboard.itv');

    Route::get('kpis', 'FleetKpiController@index')->name('kpis.index');

    Route::get('details', 'FleetDetailsController@index')->name('details.index');
    Route::put('details', 'FleetDetailsController@update')->name('details.update');
    Route::resource('users', 'FleetUserController');
    Route::resource('enterprise-groups', 'FleetEnterpriseGroupController');
    Route::resource('manufacturers', 'FleetManufacturerController');
    Route::resource('manufacturers.models', 'FleetManufacturerModelController');
    Route::resource('maintenance-plans', 'FleetMaintenancePlanController')->only(['index']);
    Route::resource('maintenance-plans.operations', 'FleetMaintenancePlanOperationController')->only(['index']);
    
    Route::get('models/{model}/handbooks', 'FleetModelHandbookController@index')->name('handbooks.index');
    Route::post('models/{model}/technical-handbook', 'FleetModelHandbookController@storeTechnical')->name('handbooks.technical.store');
    Route::delete('models/{model}/technical-handbook', 'FleetModelHandbookController@destroyTechnical')->name('handbooks.technical.destroy');
    Route::post('models/{model}/usage-handbook', 'FleetModelHandbookController@storeUsage')->name('handbooks.usage.store');
    Route::delete('models/{model}/usage-handbook', 'FleetModelHandbookController@destroyUsage')->name('handbooks.usage.destroy');


    Route::resource('repair-orders.spare-parts', 'FleetRepairOrderSparePartsController')->only(['store', 'destroy', 'update']);

    Route::resource('alerts', 'FleetAlertController')->only(['index', 'update']);
    Route::resource('garage.specialities', 'FleetGarageSpecialitiesController')->only(['index', 'update']);
    Route::resource('garage.users', 'FleetGarageUserController')->only(['index', 'update', 'store', 'destroy']);
    Route::resource('garages.customers', 'FleetGarageCustomerController')->only(['index', 'update', 'store', 'destroy']);
    Route::resource('garages', 'FleetGarageController');
    Route::resource('customers', 'FleetCustomerController');
    Route::resource('customers.garages', 'FleetCustomerGarageController');
    Route::resource('customers.vehicles', 'FleetCustomerVehicleController')->only('index');
    Route::resource('customers.users', 'FleetCustomerUserController')->only(['index', 'update', 'store', 'destroy']);
    Route::resource('vehicles', 'FleetVehicleController');
    Route::resource('vehicles.equipments', 'FleetVehicleEquipmentController')->only(['index', 'store', 'update', 'destroy', 'edit']);
    Route::resource('vehicles.files', 'FleetVehicleFileController')->only(['index', 'store', 'destroy']);
    Route::resource('vehicles.pictures', 'FleetVehiclePictureController')->only(['index', 'store', 'destroy','update']);
    Route::resource('vehicles.customers', 'FleetVehicleCustomerController')->only(['store', 'index', 'destroy']);
    Route::resource('vehicles.notes', 'FleetVehicleNoteController')->only(['index', 'store', 'update', 'destroy']);
    Route::resource('vehicles.incidents', 'FleetVehicleIncidentController')->only(['index', 'store', 'update', 'destroy']);
    
    Route::post('vehicles/{vehicle}/counters/{counter}', 'FleetVehicleCounterController@reset')->name('vehicles.counters.reset');
    Route::post('vehicles/{vehicle}/plans/counters', 'FleetVehicleCounterController@storeFromPlan');
    Route::resource('vehicles.counters', 'FleetVehicleCounterController');

    Route::get('export-vehicles', 'FleetExportController@vehicles')->name('export.vehicles');
    Route::get('export-garages', 'FleetExportController@garages')->name('export.garages');
    Route::get('export-customers', 'FleetExportController@customers')->name('export.customers');

    Route::put('repair-orders/{repair_order}/state', 'FleetRepairOrdersController@updateState')->name('repair-orders.state.update');
    Route::resource('repair-orders', 'FleetRepairOrdersController');
    Route::get('repair-orders/{repair_order}/store-simplified', 'FleetRepairOrdersController@storeSimplified')->name('repair-orders.store-simplified');
    Route::resource('repair-orders.operations', 'FleetRepairOrderOperationController')->only(['index', 'store', 'destroy', 'update']);
    Route::get('repair-orders/{repair_order}/operations/search', 'FleetRepairOrderOperationController@search')->name('repair-orders.operations.search');
    Route::resource('repair-orders.maintenance-plans', 'FleetRepairOrderMaintenancePlanController')->only(['index', 'store']);
    Route::get('repair-orders/{repair_order}/vehicle', 'FleetRepairOrdersController@vehicle')->name('repair-orders.vehicle');
    Route::get('repair-orders/{repair_order}/garage', 'FleetRepairOrdersController@garage')->name('repair-orders.garage');
    Route::put('repair-orders/{repair_order}/finish', 'FleetRepairOrdersController@finish')->name('repair-orders.finish');
    Route::get('repair-orders/{repair_order}/authorization', 'FleetRepairOrdersController@authorization')->name('repair-orders.authorization');
    Route::post('repair-orders/{repair_order}/authorize', 'FleetRepairOrdersController@authorizeRepairOrder')->name('repair-orders.authorize');
    Route::get('repair-orders/{repair_order}/operations/pdf', 'FleetRepairOrdersController@pdf')->name('repair-orders.operations.pdf');
    Route::put('repair-orders/{repair_order}/itv', 'FleetRepairOrdersController@updateItv')->name('repair-orders.itv.update');

    Route::post('repair-orders/{repair_order}/custom-operations', 'FleetRepairOrderCustomOperationController@store')->name('repair-orders.custom-operation.store');

    Route::get('repair-orders/{repair_order}/invoice', 'FleetRepairOrderInvoiceController@index')->name('repair-orders.invoice.show');

    Route::resource('test-repair-orders', 'FleetTestRepairOrdersController')->only('index', 'create', 'destroy', 'destroyPart');
    Route::put('test-repair-orders/{repair_order?}/update', 'FleetTestRepairOrdersController@update')->name('test-repair-orders.update');
    Route::get('test-repair-orders/{operations_part?}/destroyPart', 'FleetTestRepairOrdersController@destroyPart')->name('test-repair-orders.destroyPart');
    Route::get('test-repair-orders/{operation?}/destroyOperation', 'FleetTestRepairOrdersController@destroyOperation')->name('test-repair-orders.destroyOperation');
    Route::get('test-repair-orders/corrective', 'FleetTestRepairOrdersController@corrective')->name('test-repair-orders.corrective');
    Route::get('test-repair-orders/preventive', 'FleetTestRepairOrdersController@preventive')->name('test-repair-orders.preventive');
    Route::get('test-repair-orders/{repair_order?}/en-taller-correctivo', 'FleetTestRepairOrdersController@enTallerCo')->name('test-repair-orders.en-taller-correctivo');
    Route::get('test-repair-orders/{repair_order?}/en-taller-preventivo', 'FleetTestRepairOrdersController@enTallerPre')->name('test-repair-orders.en-taller-preventivo');
    Route::get('test-repair-orders/{repair_order?}/factura-pendiente', 'FleetTestRepairOrdersController@facturaPendiente')->name('test-repair-orders.factura-pendiente');
    Route::get('test-repair-orders/{repair_order?}/pendiente-cita-taller', 'FleetTestRepairOrdersController@citaTaller')->name('test-repair-orders.pendiente-cita-taller');
    Route::get('test-repair-orders/{repair_order?}/cita-preventivo-tecnico', 'FleetTestRepairOrdersController@citaPrevTec')->name('test-repair-orders.cita-preventivo-tecnico');
    Route::get('pending-job', 'FleetTestRepairOrdersController@pendingJob')->name('pending-job');
    Route::get('test-repair-orders/{repair_order?}/datos-incompletos', 'FleetTestRepairOrdersController@datosIncompletos')->name('test-repair-orders.datos-incompletos');
    Route::post('test-repair-orders/custom-operations', 'FleetTestRepairOrderCustomOperationController@store')->name('test-repair-orders.custom-operation.store');
});

Route::prefix('garage')
->name('garage.')
->namespace('Garage')
->middleware(['auth', 'user-active', 'role:garage'])
->group(function () {
    Route::get('dashboard', 'GarageRepairOrdersController@dashboard')->name('home');

    Route::put('appointments/{appointment}/vehicle', 'GarageAppointmentController@vehicleReceived')->name('appointments.vehicle-received');
    Route::resource('appointments', 'GarageAppointmentController');
    Route::resource('alerts', 'GarageAlertController')->only(['index', 'update']);
    Route::resource('vehicles', 'GarageVehiclesController')->only(['index', 'show']);
    Route::get('details', 'GarageDetailsController@index')->name('details.index');
    Route::put('details', 'GarageDetailsController@update')->name('details.update');

    
    Route::put('repair-orders/{repair_order}/itv', 'GarageRepairOrdersController@updateItv')->name('repair-orders.itv.update');
    Route::put('repair-orders/{repair_order}/state', 'GarageRepairOrdersController@updateState')->name('repair-orders.state.update');
    Route::resource('repair-orders', 'GarageRepairOrdersController')->only(['index', 'show', 'create', 'store']);
    Route::resource('repair-orders.operations', 'GarageRepairOrderOperationController')->only(['index','store', 'destroy']);
    Route::get('repair-orders/{repair_order}/operations/pdf', 'GarageRepairOrdersController@pdf')->name('repair-orders.operations.pdf');
    Route::get('repair-orders/{repair_order}/vehicle', 'GarageRepairOrdersController@vehicle')->name('repair-orders.vehicle');
    Route::get('repair-orders/{repair_order}/garage', 'GarageRepairOrdersController@garage')->name('repair-orders.garage');
    Route::get('repair-orders/{repair_order}/authorization', 'GarageRepairOrdersController@authorization')->name('repair-orders.authorization');
    Route::post('repair-orders/{repair_order}/authorize', 'GarageRepairOrdersController@authorizeRepairOrder')->name('repair-orders.authorize');
    Route::get('repair-orders/{repair_order}/operations/search', 'GarageRepairOrderOperationController@search')->name('repair-orders.operations.search');

    Route::resource('repair-orders.maintenance-plans', 'GarageRepairOrderMaintenancePlanController')->only(['index', 'store']);
    Route::resource('repair-orders.spare-parts', 'GarageRepairOrderSparePartsController')->only(['store', 'destroy', 'update']);

    Route::get('repair-orders/{repair_order}/operations/execute', 'GarageExecuteOperationController@index')->name('show.operation');
    
    Route::post('repair-orders/{repair_order}/custom-operations', 'GarageRepairOrderCustomOperationController@store')->name('repair-orders.custom-operation.store');

    Route::post('repair-orders/{repair_order}/operations/{operation}/execute', 'GarageExecuteOperationController@store')->name('execute.operation');
    Route::post('repair-orders/{repair_order}/plan/{plan}/finish', 'GarageExecuteOperationController@finish')->name('repair-orders.plan.finish');

    Route::get('repair-orders/{repair_order}/invoice', 'GarageRepairOrderInvoiceController@index')->name('repair-orders.invoice.show');
});


Route::prefix('customer')
->name('customer.')
->namespace('Customer')
->middleware(['auth', 'user-active', 'role:customer'])
->group(function () {
    Route::get('dashboard', 'CustomerVehiclesController@index')->name('home');

    Route::get('preventives/{preventive}/pdf', 'CustomerPreventiveController@pdf')->name('preventives.pdf');
    Route::resource('preventives', 'CustomerPreventiveController')->only(['index', 'show']);
    Route::resource('preventives.operations', 'CustomerPreventiveOperationController')->only(['update']);
    Route::resource('appointments', 'CustomerAppointmentController')->only(['index']);
    Route::resource('vehicles', 'CustomerVehiclesController')->only(['index', 'show']);
    Route::resource('alerts', 'CustomerAlertController')->only(['index', 'update']);
    Route::resource('vehicles.failures', 'CustomerVehicleFailureController')->only(['index', 'create', 'store']);
    Route::resource('vehicles.accident-reports', 'CustomerVehicleAccidentReportController')->only(['index', 'create', 'store']);

    Route::get('details', 'CustomerDetailsController@index')->name('details.index');
    Route::put('details', 'CustomerDetailsController@update')->name('details.update');

    Route::get('vehicle/{vehicle}/tyre-failure', 'CustomerTyreFailureController@create')->name('tyre-failure.create');
    Route::post('vehicle/{vehicle}/tyre-failure', 'CustomerTyreFailureController@store')->name('tyre-failure.store');
});


Route::prefix('auth')
->name('auth.')
->namespace('Auth')
->middleware(['auth', 'user-active'])
->group(function () {
    Route::get('profile', 'AuthProfileController@index')->name('profile.index');
    Route::put('profile', 'AuthProfileController@update')->name('profile.update');
});

Route::middleware(['auth', 'user-active'])->group(function () {
    Route::get('alert/{alert}/linking', 'AlertLinkingController@index')->name('alert.linking');
});


Route::prefix('api')
->namespace('Api')
->middleware(['auth', 'user-active'])
->group(function () {
    Route::get('/garage/search', 'SearchGarageController@index');
    Route::get('/vehicle/search', 'SearchVehicleController@index');
    Route::get('/family/{family}/subfamilies', function (OperationFamily $family) {
        return $family->subfamilies;
    });
    Route::get('/manufacturer/{manufacturer}/models', function (Manufacturer $manufacturer) {
        return $manufacturer->models()->orderBy('name')->get();
    });
    Route::get('/models/{model}/plans', function (Model $model) {
        return $model->plans()->orderBy('name')->get();
    });
});

Auth::routes();
