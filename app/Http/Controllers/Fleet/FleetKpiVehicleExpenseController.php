<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetKpiVehicleExpenseController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->from ?? now()->subMonths(3)->format('Y-m-d');
        $to = $request->to ?? now()->format('Y-m-d');

        $orders = RepairOrder::filter($request->all())
                ->where('fleet_id', Auth::user()->fleet->id)
                ->whereBetween('created_at', ["$from 00:00:00", "$to 23:59:59"])
                ->get();

        $data = $orders->map(function ($order) {
            return [
                'plate' => optional($order->vehicle)->plate,
                'total_expense' => $order->parts->sum('total_price') + $order->operations->sum('amount'),
                'parts_expense' => $order->parts->sum('total_price'),
                'operations_expense' => $order->operations->sum('amount'),
            ];
        })
        ->filter(function ($item) {
            return $item['total_expense'] > 0;
        })
        ->sortByDesc(function ($item) {
            return $item['total_expense'];
        })
        ->values()
        ->toArray();

        return view('fleet.dashboard.expense.vehicle_expense', [
            'source' => $data,
        ]);
    }
}
