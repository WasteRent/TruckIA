<?php

use App\Models\Manufacturer;
use App\Models\OperationFamily;
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

Route::get('/garage/search', 'Api\SearchGarageController@index');
Route::get('/vehicle/search', 'Api\SearchVehicleController@index');


Route::get('/family/{family}/subfamilies', function (OperationFamily $family) {
    return $family->subfamilies;
});

Route::get('/manufacturer/{manufacturer}/models', function (Manufacturer $manufacturer) {
    return $manufacturer->models()->orderBy('name')->get();
});
