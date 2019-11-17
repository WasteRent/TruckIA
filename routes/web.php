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

Route::get('/', function () {
    return redirect()->route('admin.maintenance-plans.index');
});


Route::prefix('admin')
->name('admin.')
->namespace('Admin')
->middleware([])
->group(function () {
    Route::resource('maintenance-plans', 'AdminMaintenancePlanController');
    Route::resource('maintenance-operations', 'AdminMaintenanceOperationController')->only(['update', 'destroy']);
});
