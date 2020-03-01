<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use App\Models\RepairOrderState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GarageRepairOrdersController extends Controller
{
    public function index(Request $request)
    {
        $filters = RepairOrder::filters($request->all());

        $orders = Auth::user()->garage->repairOrders()
        ->where($filters)
        ->whereIn('state_id', [
            RepairOrderState::AUTHORIZED,
            RepairOrderState::REPAIRING,
            RepairOrderState::FINISHED
        ])
        ->latest()
        ->get();

        return view('garage.repair_orders.index', [
            'repair_orders' => $orders,
            'states' => RepairOrderState::all()
        ]);
    }

    public function show(RepairOrder $repair_order)
    {
        return view('garage.repair_orders.show', [
            'repair_order' => $repair_order
        ]);
    }
}
