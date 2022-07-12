<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenancePlanOperation;
use App\Models\SparePart;
use Illuminate\Http\Request;

class AdminMaintenancePlanOperationSparePartController extends Controller
{
    public function index(int $operation_id)
    {
        return view('admin.maintenance_plans.operations.spare_parts.index', [
            'operation' => MaintenancePlanOperation::find($operation_id),
        ]);
    }

    public function create(int $operation_id)
    {
        return view('admin.maintenance_plans.operations.spare_parts.create', [
            'operation' => MaintenancePlanOperation::find($operation_id),
        ]);
    }

    public function store(Request $request, int $operation_id)
    {
        $operation = MaintenancePlanOperation::find($operation_id);

        $part = SparePart::create([
            'manufacturer' => $request->manufacturer,
            'reference' => $request->reference,
            'unit_price' => $request->unit_price,
            'description' => $request->description,
            'vehicle_manufacturer_id' => $operation->plan->manufacturer->id,
            'vehicle_model_id' => $operation->plan->model->id,
            'vehicle_maintenance_plan_id' => $operation->plan->id,
            'vehicle_maintenance_plan_operation_id' => $operation_id,
        ]);

        return $this->index($operation_id);
    }
}
