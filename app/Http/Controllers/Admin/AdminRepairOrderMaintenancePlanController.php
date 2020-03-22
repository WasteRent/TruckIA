<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenancePlan;
use App\Models\RepairOrder;
use Illuminate\Http\Request;

class AdminRepairOrderMaintenancePlanController extends Controller
{

    public function index(Request $request, RepairOrder $repair_order)
    {
        return view('admin.repair_orders.operations.plans', [
            'repair_order' => $repair_order,
            'plans' => MaintenancePlan::all(),
        ]);
    }

    public function store(Request $request, RepairOrder $repair_order)
    {
        $plan = MaintenancePlan::findOrFail($request->plan_id);

        foreach ($plan->operations as $operation) {
            $repair_order->operations()->attach($operation->id);
        }

        return redirect()->route('admin.repair-orders.operations.index', $repair_order)
            ->with('success_message', 'Operaciónes añadidas correctamente');
    }
}
