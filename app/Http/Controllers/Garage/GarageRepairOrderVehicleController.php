<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use App\Models\Vehicle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GarageRepairOrderVehicleController extends Controller
{

    public function create(Request $request, int $repair_order_id)
    {
        $repair_order = RepairOrder::findOrFail($repair_order_id);
        
        $vehicles = Auth::user()->garage->vehicles()->where(Vehicle::filters($request->all()))->get();

        return view('garage.repair_orders.vehicle.create', [
            'repair_order' => $repair_order,
            'vehicles_search' => $vehicles
        ]);
    }


    public function store(Request $request, int $repair_order_id)
    {
        if (!$request->vehicle_id) {
            throw new Exception('vehicle_id field not found');
        }
        
        $repair_order = RepairOrder::findOrFail($repair_order_id);
        $repair_order->vehicle_id = $request->vehicle_id;
        $repair_order->save();

        return redirect()->route('garage.repair-orders.operations.index', $repair_order);
    }
}
