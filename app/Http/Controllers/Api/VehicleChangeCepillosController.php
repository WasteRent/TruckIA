<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\RepairOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleChangeCepillosController extends Controller
{
    //3. Obtener cambios de cepillos
    public function index(Request $request)
    {
        $user = User::find(1031);
        $orders = RepairOrder::where('fleet_id', $user->fleet->id)->where('type', '??')->get(); //aqui por tipo? en la tabla preentive_operations->operation_name veo que hay limpieza y revision, es esto?

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No existen vehículos'], 404);
        }

        $data = $orders->map(function ($order) {
            return [
                //donde saco todos estos campos?
                "IDActivo" => $order->vehicle->fleet->id, //IDActivo
                "FechaRealizacion" =>  $vehicle->fleet->id, // FechaRealizacion
                "UndCambiadas" => "FURGON HIDROLIMPIADOR", //UndCambiadas
                "MarcaUndQuitada" => $vehicle->deliveries->first()?->id,//MarcaUndQuitada
                "MarcaUndNueva" => $vehicle->deliveries->first()?->contract_type, //MarcaUndNueva
                "DescMarcaActivo" => $vehicle->deliveries->first()?->contract_type, //DescMarcaActivo
            ];
        })->toArray();


        return response()->json(['data' => $data], 200);
    }
}
