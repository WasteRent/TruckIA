<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\ExecuteOperationRequest;
use App\Models\Operation;
use App\Models\RepairOrder;
use App\Models\RepairOrderState;
use Illuminate\Support\Facades\Auth;

class GarageExecuteOperationController extends Controller
{
    public function show(RepairOrder $repair_order, Operation $operation)
    {
        if (Auth::user()->garage->id != $repair_order->garage->id) {
            abort(403);
        }

        return view('garage.repair_orders.execute.index', [
            'repair_order' => $repair_order,
            'current_operation' => $repair_order->operations()->whereId($operation->id)->first()
        ]);
    }

    public function store(ExecuteOperationRequest $request, RepairOrder $repair_order, Operation $operation)
    {
        if (Auth::user()->garage->id != $repair_order->garage->id) {
            abort(403);
        }

        $with_file = false;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $request->file->store('truckts/mantenimientos/operaciones');
            $with_file = true;
        }

        $repair_order->operations()->updateExistingPivot($operation, [
            'real_time_in_hours' => $request->real_time_in_hours,
            'observations' => $request->observations,
            'file' => $with_file ? $request->file->hashName() : null,
            'completed_at' => new \DateTime,
            'completed' => true
        ]);

        $this->checkState($repair_order);

        return back()->with('success_message', 'Operación completada con éxito');
    }

    private function checkState(RepairOrder $repair_order)
    {
        if ($repair_order->state_id != RepairOrderState::REPAIRING) {
            $repair_order->state_id = RepairOrderState::REPAIRING;
            $repair_order->save();
        }

        if ($repair_order->isFinished()) {
            $repair_order->state_id = RepairOrderState::FINISHED;
            $repair_order->save();
        }
    }
}
