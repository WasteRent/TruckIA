<?php

use App\User;
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


Route::post('/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return ['token' => $user->createToken($request->email)->plainTextToken];
});



Route::namespace('Api')
->middleware('auth:sanctum')
->group(function () {
    Route::get('/vehiculos', 'VehicleController@index');
    Route::get('/vehiculos/cambio-cepillos', 'VehicleChangeBrushesController@index');
    Route::get('/vehiculos/cambio-neumaticos', 'VehicleChangeTiresController@index');
    Route::get('/vehiculos/reparaciones', 'VehicleRepairsController@index');

    Route::post('/incident', 'IncidentController@store');
});