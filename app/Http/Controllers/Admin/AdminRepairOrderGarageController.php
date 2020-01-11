<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Garage;
use App\Models\RepairOrder;
use Illuminate\Http\Request;
use Exception;

class AdminRepairOrderGarageController extends Controller
{

    public function create(Request $request, int $repair_order_id)
    {
        $repair_order = RepairOrder::findOrFail($repair_order_id);
        
        return view('admin.repair_orders.garage.create', [
            'repair_order' => $repair_order,
            'garages_search' => Garage::where(Garage::filters($request->all()))->get()
        ]);
    }

    public function edit(Request $request, int $repair_order_id, int $garage_id)
    {
        $repair_order = RepairOrder::findOrFail($repair_order_id);
        $selected_garage = Garage::findOrFail($garage_id);
        
        return view('admin.repair_orders.garage.edit', [
            'repair_order' => $repair_order,
            'selected_garage' => $selected_garage,
            'garages_search' => Garage::where(Garage::filters($request->all()))->get()
        ]);
    }

    public function update(Request $request, int $repair_order_id, int $garage_id)
    {
        if (!$request->new_garage_id) {
            throw new Exception('new_garage_id field not found');
        }

        $repair_order = RepairOrder::findOrFail($repair_order_id);
        $repair_order->garage_id = $request->new_garage_id;
        $repair_order->save();

        return redirect()->route('admin.repair-orders.garages.edit', [$repair_order, $request->new_garage_id]);
    }

    public function store(Request $request, int $repair_order_id)
    {
        if (!$request->garage_id) {
            throw new Exception('garage_id field not found');
        }
        
        $repair_order = RepairOrder::findOrFail($repair_order_id);
        $repair_order->garage_id = $request->garage_id;
        $repair_order->save();

        dd(123);
    }
}
