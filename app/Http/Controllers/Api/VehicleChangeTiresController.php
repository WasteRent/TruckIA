<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\RepairOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleChangeTiresController extends Controller
{
    //4. Obtener cambios de neumáticos:
    public function index(Request $request)
    {
        $user = User::find(1031);
        $orders = RepairOrder::where('fleet_id', $user->fleet->id)->where('type', 'tires')->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No existen vehículos'], 404);
        }

        $data = $orders->map(function ($order) {
            return [
                "IDActivo" => $order->vehicle->fleet->id, //IDActivo
                "date" =>  $order->finished_at->format('d/m/Y H:i:s'), // FechaRealizacion
                "UndCambiadas" => 123, //UndCambiadas //donde veo las unidades?
                "DescMaterial" => 'NEUMATICO', //un poco absurdo este campo no? O todavia hay neumaticos de madera?
            ];
        })->toArray();


        return response()->json(['data' => $data], 200);
    }
}
