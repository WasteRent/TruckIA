<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\RepairOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleChangeTiresController extends Controller
{
    public function index(Request $request)
    {
        $repairOrders = RepairOrder::filter($request->all())
            ->with('operations')
            ->where('fleet_id', 30)
            ->whereHas('operations', function ($query) {
                $query->where(function ($q) {
                    $q->where('operation_name', 'like', '%neumaticos%')
                        ->where('operation_description', 'like', '%neumaticos%');
                })
                    ->where(function ($q) {
                        $q->where('operation_name', 'like', '%cambiar%')
                            ->orWhere('operation_name', 'like', '%cambio%')
                            ->orWhere('operation_name', 'like', '%SUSTITUIR%')
                            ->orWhere('operation_name', 'like', '%sustitucion%')
                            ->orWhere('operation_description', 'like', '%cambiar%')
                            ->orWhere('operation_description', 'like', '%cambio%')
                            ->orWhere('operation_description', 'like', '%SUSTITUIR%')
                            ->orWhere('operation_description', 'like', '%sustitucion%');
                    });
            })
            ->get();

        if ($repairOrders->isEmpty()) {
            return response()->json([], 404);
        }

        $data = $repairOrders->map(function ($order) {
            return [
                "id" => $order->id,
                "internal_id" => $order->vehicle->internal_id,
                "fleet_id" =>  $order->fleet->id,
                "fleet" =>  $order->fleet->name,
                "plate" => $order->vehicle->plate,
                "FechaRealizacion" => $order->finished_at
            ];
        })->toArray();


        return response()->json(['data' => $data], 200);
    }
}
