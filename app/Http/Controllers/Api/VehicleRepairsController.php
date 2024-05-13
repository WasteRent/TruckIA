<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\RepairOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleRepairsController extends Controller
{
    public function index(Request $request)
    {
        $orders = RepairOrder::filter($request->all())->where('fleet_id', auth()->user()->fleet->id)->get();

        $data = $orders->map(function ($order) {
            return [
                "id" => $order->id,
                "internal_id" => $order->vehicle->internal_id,
                "fleet_id" =>  $order->fleet->id,
                "fleet" =>  $order->fleet->name,
                'plate' => $order->vehicle?->plate,
                'date' => $order->created_at->format('Y-m-d H:i:s'),
                'total' => $order->operations->sum('amount'),
            ];
        })->toArray();


        return response()->json(['data' => $data], 200);
    }
}
