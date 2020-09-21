<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\MaintenancePlan;

class FleetMaintenancePlanOperationController extends Controller
{

    public function index(int $plan_id)
    {
        $plan = MaintenancePlan::findOrFail($plan_id);
        return view('fleet.maintenance_plans.operations.index', [
            'plan' => $plan,
            'operations' => $plan->operations
        ]);
    }
}
