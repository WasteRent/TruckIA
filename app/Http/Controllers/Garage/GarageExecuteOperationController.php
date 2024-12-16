<?php

namespace App\Http\Controllers\Garage;

use App\Classes\RapairOrderStateService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\ExecuteOperationRequest;
use App\Models\File;
use App\Models\MaintenancePlan;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use App\Models\RepairOrderState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GarageExecuteOperationController extends Controller
{
    public function index(Request $request, RepairOrder $repair_order)
    {
        if (Auth::user()->garage->id != $repair_order->garage->id) {
            abort(403);
        }

        $operations = $repair_order->operations;

        if ($request->plan_id) {
            $operations = $operations->where('maintenance_plan_id', $request->plan_id);
        }

        return view('garage.repair_orders.execute.index', [
            'plan' => $request->plan_id ? MaintenancePlan::find($request->plan_id) : null,
            'repair_order' => $repair_order,
            'operations' => $operations->sortBy(function ($operation) {
                return $operation->isCompleted();
            }),
        ]);
    }

    public function store(ExecuteOperationRequest $request, RepairOrder $repair_order, RepairOrderOperation $operation)
    {
        if (Auth::user()->garage->id != $repair_order->garage->id) {
            abort(403);
        }

        // if ($repair_order->parts->where('total_price', null)->count() > 0) {
        //     return back()->with('error_message', 'Debes indicar el importe de los recambios.');
        // }

        $file = null;
        if ($request->hasFile('file')) {
            $file = File::storeFile($request->file, "OR {$repair_order->id}");
        }

        $operation->update([
            'user_id' => Auth::user()->id,
            'real_time_in_hours' => $request->real_time_in_hours,
            'garage_observations' => $request->toArray()['garage_observations_'.$operation->id],
            'file_id' => optional($file)->id,
            'completed_at' => new \DateTime,
        ]);

        $this->checkState($repair_order);

        return back()->with('success_message', 'Operación completada con éxito');
    }

    public function finish(Request $request, RepairOrder $repair_order, MaintenancePlan $plan)
    {
        $request->validate(['finish_total_time' => 'required|numeric|gt:0']);

        $repair_order->operations->filter(function ($operation) use ($plan) {
            return $operation->maintenance_plan_id == $plan->id;
        })->filter(function ($operation) {
            return ! $operation->isCompleted();
        })->each(function ($operation) {
            $operation->update(['user_id' => Auth::user()->id, 'completed_at' => new \DateTime]);
        });

        $ops_total = $repair_order->operations->filter(function ($operation) use ($plan) {
            return $operation->maintenance_plan_id == $plan->id;
        })->count();

        $repair_order->operations()->where('maintenance_plan_id', $plan->id)->update([
            'real_time_in_hours' => $request->finish_total_time / $ops_total,
            'completed_at' => new \DateTime,
        ]);

        if ($repair_order->operations()->whereNull('completed_at')->count() == 0) {
            RapairOrderStateService::transit($repair_order->id, RepairOrderState::PENDING_MANAGER_REVIEW);
        }

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
                RapairOrderStateService::transit($repair_order->id, RepairOrderState::PENDING_MANAGER_REVIEW);
            }
        }
    }
}
