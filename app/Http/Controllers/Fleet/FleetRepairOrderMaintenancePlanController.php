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
        $common_plans = MaintenancePlan::whereNull('manufacturer_id')->whereNull('model_id')->get();

        return view('fleet.repair_orders.operations.plans', [
            'repair_order' => $repair_order,
            'plans' => $plans->merge($common_plans)
        ]);
    }

    public function store(Request $request, RepairOrder $repair_order)
    {
        $plan = MaintenancePlan::findOrFail($request->plan_id);

        foreach ($plan->operations as $operation) {
            $repair_order->operations()->save(new RepairOrderOperation([
                'operation_attachment_file_id' => $operation->attachment_file_id,
                'operation_family' => $operation->family->name,
                'operation_subfamily' => $operation->subfamily->name,
                'operation_name' => $operation->name,
                'operation_description' => $operation->description,
                'estimated_time_in_hours' => $operation->time_in_hours
            ]));
        }

        return redirect()->route('fleet.repair-orders.operations.index', $repair_order)
            ->with('success_message', 'Operaciónes añadidas correctamente');
    }
}
