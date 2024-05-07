<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\User;
use Illuminate\Http\Request;

class VehicleActivitiesController extends Controller
{
    //2. Obtener kilometraje
    public function index(Request $request)
    {
        $user = User::find(1031);
        $vehicles = Vehicle::whereHas('tracking')->where('fleet_id', $user->fleet->id)->get();

        if ($vehicles->isEmpty()) {
            return response()->json(['message' => 'No existen vehículos'], 404);
        }

        $data = $vehicles->map(function ($vehicle) {
            $tracking = $vehicle->tracking()?->orderByDesc('fired_at')->first();
            return [
                "IDActivo" => $vehicle->plate, //IDActivo
                "total_kms" =>  $tracking->kms, // Medida
                "Fecha" =>  $tracking->created_at->format('d/m/Y H:i:s'), //Fecha
                "IDUDMedida" =>'00',//IDUDMedida que medida es?
                "DescUdMedida" => $vehicle->deliveries->first()?->contract_type, //DescUdMedida ??no tengo claro este campo que es
            ];
        })->toArray();

        return response()->json(['data' => $data], 200);

    }
}
