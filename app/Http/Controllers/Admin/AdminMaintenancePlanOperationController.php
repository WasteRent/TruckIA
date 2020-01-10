<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenancePlan;
use App\Models\Operation;
use Illuminate\Http\Request;

class AdminMaintenancePlanOperationController extends Controller
{

    public function index(int $plan_id)
    {
        $plan = MaintenancePlan::findOrFail($plan_id);
        return view('admin.maintenance_plans.operations.index', [
            'plan' => $plan,
            'operations' => $plan->operations
        ]);
    }

    public function search(Request $request, int $plan_id)
    {
        $plan = MaintenancePlan::findOrFail($plan_id);

        $filters = Operation::filters($request->all());
        $operations_search = Operation::where($filters)->orderBy('code')->get();

        return view('admin.maintenance_plans.operations.index', [
            'plan' => $plan,
            'operations' => $plan->operations,
            'operations_search' => $operations_search
        ]);
    }


    public function store(Request $request, int $plan_id)
    {
        $plan = MaintenancePlan::findOrFail($plan_id);

        if ($plan->operations->contains($request->operation_id)) {
            return back()->with('error_message', 'Esta operación ya existe en el plan de mantenimiento');
        }

        $plan->operations()->attach($request->operation_id);

        return redirect()->route('admin.maintenance-plans.operations.index', $plan)
            ->with('success_message', 'Operación añadida al plan de mantenimiento');
    }


    public function destroy(int $plan_id, int $operation_id)
    {
        $plan = MaintenancePlan::findOrFail($plan_id);

        $plan->operations()->detach($operation_id);

        return redirect()->route('admin.maintenance-plans.operations.index', $plan)
            ->with('success_message', 'Operación eliminada del plan de mantenimiento');
    }
}
