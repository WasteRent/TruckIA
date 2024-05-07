<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleTracking;
use App\User;
use Illuminate\Http\Request;

class VehicleFuelConsumptionController extends Controller
{
    //6. Obtener consumos de combustible
    public function index(Request $request)
    {
        $user = User::find(1031);
        $trackings = VehicleTracking::whereHas('vehicle', function ($query) use ($user) {
            $query->where('fleet_id', $user->fleet->id);
        })->get();

        if ($trackings->isEmpty()) {
            return response()->json(['message' => 'No existen vehículos'], 404);
        }

        $data = $trackings->map(function ($tracking) {
            return [
                "IDActivo" => $tracking->vehicle?->plate, //IDActivo
                "Fecha" =>  $tracking->fired_at->format('d/m/Y H:i:s'), // Fecha
                "TipoCombustible" => $tracking->vehicle?->fuel, //TipoCombustible
                "ValorConsumo" => 104.270, //ValorConsumo tengo duda si debe ser o kms, fuel_level_percent u  otro...
                "UnidadConsumo" => "Litros", //TipoCombustible
            ];
        })->toArray();

        return response()->json(['data' => $data], 200);
    }
}
