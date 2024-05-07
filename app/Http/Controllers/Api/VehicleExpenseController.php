<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\RepairOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleExpenseController extends Controller
{
    //7. Obtener costes de mantenimiento
    public function index(Request $request)
    {
        $user = User::find(1031);
        $orders = RepairOrder::query()->where('fleet_id', $user->fleet->id)->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No existen vehículos'], 404);
        }

        $data = $orders->map(function ($order) {
            return [
                'plate' => $order->vehicle?->plate, // IDActivo
                'NROT' => 'NROT', //no tengo claro este campo
                'date' => $order->created_at->format('d/m/Y H:i:s'), //FechaRealizacion
                'total' => $order->operations->sum('amount'), //TotalCoste
            ];
        })->toArray();


        return response()->json(['data' => $data], 200);
    }
}
