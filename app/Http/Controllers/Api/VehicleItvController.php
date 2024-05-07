<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\User;
use Illuminate\Http\Request;

class VehicleItvController extends Controller
{
    //5. Obtener información sobre ITV
    public function index(Request $request)
    {
        $user = User::find(1031);
        $vehicles = Vehicle::query()->where('fleet_id', $user->fleet->id)->get();

        if ($vehicles->isEmpty()) {
            return response()->json(['message' => 'No existen vehículos'], 404);
        }

        $data = $vehicles->map(function ($vehicle) {
            return [
                "IDActivo" => $vehicle->fleet->id, //IDActivo
                "itv_date" =>  $vehicle->itv_date, // FechaProxITV
                "expired" => $vehicle->itv_date < date('Y-m-d'), //Cumplida
            ];
        })->toArray();

        return response()->json(['data' => $data], 200);
    }
}
