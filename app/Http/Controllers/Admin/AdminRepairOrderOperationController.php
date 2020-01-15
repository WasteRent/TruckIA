<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use App\Models\RepairOrder;
use Illuminate\Http\Request;

class AdminRepairOrderOperationController extends Controller
{

    public function index(Request $request, RepairOrder $repair_order)
    {
        $filters = Operation::filters($request->all());
        $operations_search = Operation::where($filters)->orderBy('code')->get();

        return view('admin.repair_orders.operations.index', [
            'repair_order' => $repair_order,
            'operations' => $repair_order->operations,
            'operations_search' => $operations_search
        ]);
    }

    // public function create(Request $request, int $repair_order_id)
    // {
    //     $repair_order = RepairOrder::findOrFail($repair_order_id);
        
    //     return view('admin.repair_orders.vehicle.create', [
    //         'repair_order' => $repair_order,
    //         'vehicles_search' => Vehicle::where(Vehicle::filters($request->all()))->get()
    //     ]);
    // }

    // public function edit(Request $request, int $repair_order_id, int $vehicle_id)
    // {
    //     $repair_order = RepairOrder::findOrFail($repair_order_id);
    //     $selected_vehicle = Vehicle::findOrFail($vehicle_id);
        
    //     return view('admin.repair_orders.vehicle.edit', [
    //         'repair_order' => $repair_order,
    //         'selected_vehicle' => $selected_vehicle,
    //         'vehicles_search' => Vehicle::where(Vehicle::filters($request->all()))->get()
    //     ]);
    // }

    // public function update(Request $request, int $repair_order_id, int $vehicle_id)
    // {
    //     if (!$request->new_vehicle_id) {
    //         throw new Exception('new_vehicle_id field not found');
    //     }

    //     $repair_order = RepairOrder::findOrFail($repair_order_id);
    //     $repair_order->vehicle_id = $request->new_vehicle_id;
    //     $repair_order->save();

    //     return redirect()->route('admin.repair-orders.vehicles.edit', [$repair_order, $request->new_vehicle_id]);
    // }

    // public function store(Request $request, int $repair_order_id)
    // {
    //     if (!$request->vehicle_id) {
    //         throw new Exception('vehicle_id field not found');
    //     }
        
    //     $repair_order = RepairOrder::findOrFail($repair_order_id);
    //     $repair_order->vehicle_id = $request->vehicle_id;
    //     $repair_order->save();

    //     return redirect()->route('admin.repair-orders.garages.create', $repair_order);
    // }
}
