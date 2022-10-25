<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaintenancePlanOperationRequest;
use App\Models\File;
use App\Models\MaintenancePlan;
use App\Models\MaintenancePlanOperation;
use App\Models\OperationFamily;
use App\Models\OperationSubfamily;

class FleetMaintenancePlanOperationController extends Controller
{
    public function index(int $plan_id)
    {
        $plan = MaintenancePlan::findOrFail($plan_id);

        return view('fleet.maintenance_plans.operations.index', [
            'plan' => $plan,
            'operations' => $plan->operations,
        ]);
    }

    public function create(int $plan_id)
    {
        $plan = MaintenancePlan::findOrFail($plan_id);

        return view('fleet.maintenance_plans.operations.create', [
            'plan' => $plan,
            'families' => OperationFamily::all(),
            'subfamilies' => OperationSubfamily::where('family_id', session('_old_input')['family_id'] ?? ['']),
        ]);
    }

    public function store(MaintenancePlanOperationRequest $request, int $plan_id)
    {
        $plan = MaintenancePlan::findOrFail($plan_id);
        $operation = new MaintenancePlanOperation($request->toArray());

        if ($request->attachment) {
            $file = File::storeFile($request->attachment);
            $operation->attachment_file_id = $file->id;
        }

        $plan->operations()->save($operation);

        return redirect()->route('fleet.maintenance-plans.operations.index', $plan)
            ->with('success_message', 'Operación añadida al plan de mantenimiento');
    }

    public function edit(int $plan_id, int $operation_id)
    {
        $plan = MaintenancePlan::findOrFail($plan_id);
        $operation = MaintenancePlanOperation::findOrFail($operation_id);

        return view('fleet.maintenance_plans.operations.edit', [
            'plan' => $plan,
            'operation' => $operation,
            'families' => OperationFamily::all(),
            'subfamilies' => OperationSubfamily::where('family_id', $operation->subfamily->family->id)->get(),
        ]);
    }

    public function update(MaintenancePlanOperationRequest $request, int $plan_id, int $operation_id)
    {
        $plan = MaintenancePlan::findOrFail($plan_id);

        $operation = MaintenancePlanOperation::findOrFail($operation_id);
        $operation->update($request->toArray());

        if ($request->attachment) {
            $file = File::storeFile($request->attachment);
            $operation->attachment_file_id = $file->id;
            $operation->save();
        }

        return redirect()->route('fleet.maintenance-plans.operations.index', $plan)
            ->with('success_message', 'Operación añadida al plan de mantenimiento');
    }

    public function destroy(int $plan_id, int $operation_id)
    {
        MaintenancePlanOperation::destroy($operation_id);

        $plan = MaintenancePlan::findOrFail($plan_id);

        return redirect()->route('fleet.maintenance-plans.operations.index', $plan)
            ->with('success_message', 'Operación eliminada del plan de mantenimiento');
    }

    public function removeImage(int $plan_id, int $operation_id)
    {
        $operation = MaintenancePlanOperation::findOrFail($operation_id);

        $operation->attachment_file_id = null;
        $operation->save();

        return back()->with('success_message', 'Imagen eliminada');
    }
}
