<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use App\Models\VehicleIncident;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetKpiVehicleExpenseController extends Controller
{
    
    public function index(Request $request)
    {
        $to = $request->to;
        $from = $request->from;

        $orders = RepairOrder::query()
                ->where('fleet_id', Auth::user()->fleet->id) 
                ->whereBetween('created_at', ["$from 00:00:00", "$to 23:59:59"])
                ->get();

        $data = $orders->map(function($order) {
            return [
                'plate' => $order->vehicle->plate,
                'total_expense' => $order->parts->sum('total_price') + $order->operations->sum('amount'),
                'parts_expense' => $order->parts->sum('total_price'),
                'operations_expense' => $order->operations->sum('amount')
            ];
        })
        ->filter(function($item) {
            return $item['total_expense'] > 0;
        })
        ->sortByDesc(function($item) {
            return $item['total_expense'];
        })
        ->values()
        ->toArray();



        return view('fleet.dashboard.vehicle_expense', [
            'source' => $data
        ]);
    }
}
