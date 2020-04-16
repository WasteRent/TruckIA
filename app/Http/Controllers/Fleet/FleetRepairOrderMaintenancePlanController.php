<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\MaintenancePlan;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class FleetRepairOrderMaintenancePlanController extends Controller
{

    public function index(Request $request, RepairOrder $repair_order)
    {
        $plans = Vehicle::findOrFail($repair_order->vehicle_id)->getMaintenancePlans();

        return view('fleet.repair_orders.operations.plans', [
            'repair_order' => $repair_order,
            'plans' => $plans
        ]);
    }

    public function store(Request $request, RepairOrder $repair_order)
    {
        $plan = MaintenancePlan::findOrFail($request->plan_id);

        foreach ($plan->operations as $operation) {
            $repair_order->operations()->save(new RepairOrderOperation([
                'operation_family' => $operation->family->name,
                'operation_subfamily' => $operation->subfamily->name,
                'operation_code' => $operation->code,
                'operation_name' => $operation->name,
                'operation_description' => $operation->description,
                'estimated_time_in_hours' => $operation->time_in_hours
            ]));
        }

        return redirect()->route('fleet.repair-orders.operations.index', $repair_order)
            ->with('success_message', 'Operaciónes añadidas correctamente');
    }
}
