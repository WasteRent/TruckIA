<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaintenanceOperationRequest;
use App\Models\MaintenanceOperation;
use App\Models\MaintenanceOperationType;
use App\Models\MaintenancePlan;

class AdminMaintenanceOperationController extends Controller
{

    public function create(int $plan_id)
    {
        return view('admin.maintenance.operations.create', [
            'plan' => MaintenancePlan::findOrFail($plan_id),
            'operation_types' => MaintenanceOperationType::all()
        ]);
    }

    public function store(MaintenanceOperationRequest $request, int $plan_id)
    {
        $plan = MaintenancePlan::findOrFail($plan_id);
        $operation = new MaintenanceOperation($request->all());
            
        $plan->operations()->save($operation);

        return redirect()->route('admin.maintenance-plans.edit', $plan)
                        ->with('success_message', 'Operación creada');
    }

    public function update(MaintenanceOperationRequest $request, int $plan_id, int $operation_id)
    {
        MaintenanceOperation::findOrFail($operation_id)->update($request->all());
        return back()->with('success_message', 'Operación actualizada');
    }

    public function destroy(int $operation_id)
    {
        MaintenanceOperation::destroy($operation_id);
        return back()->with('success_message', 'Operación eliminada');
    }
}
