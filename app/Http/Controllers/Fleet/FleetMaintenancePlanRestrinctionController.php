<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\FleetMaintenanceOperationRestriction;
use App\Models\MaintenancePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetMaintenancePlanRestrinctionController extends Controller
{
    public function update(Request $request, MaintenancePlan $plan)
    {
        $res = FleetMaintenanceOperationRestriction::where([
            'plan_id' => $plan->id, 
            'operation_id' => $request->operation_id,
            'fleet_id' => auth()->user()->fleet->id
        ])->first();

        if ($res) {
            FleetMaintenanceOperationRestriction::where([
                'plan_id' => $plan->id, 
                'operation_id' => $request->operation_id,
                'fleet_id' => auth()->user()->fleet->id
            ])->delete();
        } else {
            FleetMaintenanceOperationRestriction::create([
                'plan_id' => $plan->id, 
                'operation_id' => $request->operation_id,
                'fleet_id' => auth()->user()->fleet->id
            ]);
        }

        return back();
    }
}
