<?php

namespace App\Http\Controllers\Garage;

use App\Classes\RapairOrderStateService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\ExecuteOperationRequest;
use App\Models\File;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use App\Models\RepairOrderState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GarageExecuteOperationController extends Controller
{

    public function index(RepairOrder $repair_order)
    {
        if (Auth::user()->garage->id != $repair_order->garage->id) {
            abort(403);
        }

        return view('garage.repair_orders.execute.index', [
            'repair_order' => $repair_order,
            'operations' => $repair_order->operations->sortBy(function ($operation) {
                return $operation->isCompleted();
            })
        ]);
    }

    public function store(ExecuteOperationRequest $request, RepairOrder $repair_order, RepairOrderOperation $operation)
    {
        if (Auth::user()->garage->id != $repair_order->garage->id) {
            abort(403);
        }

        $file = null;
        if ($request->hasFile('file')) {
            $file = File::storeFile($request->file, "OR {$repair_order->id}");
        }

        $operation->update([
            'user_id' => Auth::user()->id,
            'real_time_in_hours' => $request->real_time_in_hours,
            'garage_observations' => $request->garage_observations,
            'file_id' => optional($file)->id,
            'completed_at' => new \DateTime,
        ]);

        $this->checkState($repair_order);

        return back()->with('success_message', 'Operación completada con éxito');
    }

    public function finish(Request $request, RepairOrder $repair_order)
    {
        $request->validate(['finish_total_time' => 'required|numeric|gt:0']);

        $repair_order->operations->filter(function ($operation) {
            return !$operation->isCompleted();
        })->each(function ($operation) {
            $operation->update(['user_id' => Auth::user()->id, 'completed_at' => new \DateTime]);
        });

        $repair_order->operations()->save(new RepairOrderOperation([
            'operation_name' => 'Gama completada',
            'operation_description' => 'Gama completada',
            'estimated_time_in_hours' => $request->finish_total_time,
            'real_time_in_hours' => $request->finish_total_time,
            'completed_at' => new \DateTime
        ]));

        RapairOrderStateService::transit($repair_order->id, RepairOrderState::FINISHED);

        return back()->with('success_message', 'Operaciones completadas con éxito');
    }

    private function checkState(RepairOrder $repair_order)
    {
        if ($repair_order->state_id != RepairOrderState::REPAIRING) {
            RapairOrderStateService::transit($repair_order->id, RepairOrderState::REPAIRING);
        }

        if ($repair_order->operations()->whereNull('completed_at')->count() == 0) {
            if ($repair_order->type == 'pre-itv') {
                RapairOrderStateService::transit($repair_order->id, RepairOrderState::FINISHED_PREITV);
            } else {
                RapairOrderStateService::transit($repair_order->id, RepairOrderState::FINISHED);
            }
        }
    }
}
