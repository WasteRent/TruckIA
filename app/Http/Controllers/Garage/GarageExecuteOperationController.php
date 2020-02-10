<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\ExecuteOperationRequest;
use App\Models\Operation;
use App\Models\RepairOrder;

class GarageExecuteOperationController extends Controller
{
    public function show(RepairOrder $repair_order, Operation $operation)
    {
        return view('garage.repair_orders.execute', [
            'repair_order' => $repair_order,
            'current_operation' => $operation
        ]);
    }

    public function store(ExecuteOperationRequest $request, RepairOrder $repair_order, Operation $operation)
    {
        $with_file = false;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $request->file->store('repair_order_operations');
            $with_file = true;
        }

        $repair_order->operations()->updateExistingPivot($operation, [
            'real_time_in_hours' => $request->real_time_in_hours,
            'observations' => $request->observations,
            'file' => $with_file ? $request->file->hashName() : null,
            'completed' => true
        ]);

        return back()->with('success_message', 'Operación completada con éxito');
    }
}
