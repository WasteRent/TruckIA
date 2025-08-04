<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\RapairOrderStateService;
use App\Classes\RepairOrderReferenceGenerator;
use App\Http\Controllers\Controller;
use App\Models\MaintenancePlan;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use App\Models\RepairOrderState;
use App\Models\Vehicle;
use App\Models\VehicleWorkCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;


class FleetVehicleInitialMaintenanceStateController extends Controller
{
    /**
     * Store the initial maintenance state for vehicle counters
     */
    public function store(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'counters' => 'required|array',
            'counters.*' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $this->createOrders($request, $vehicle);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return back();
    }

    private function createOrders(Request $request, Vehicle $vehicle) {
        foreach ($request->counters as $counter_id => $valor) {
            if (!empty($valor) && is_numeric($valor)) {
                $counter = VehicleWorkCounter::findOrFail($counter_id);
                $plan = MaintenancePlan::findOrFail($counter->plan_id);

                $order = new RepairOrder();
                $order->reference = RepairOrderReferenceGenerator::generate(Auth::user()->fleet);
                $order->fleet_id = Auth::user()->fleet->id;
                $order->state_id = RepairOrderState::AUTHORIZED;
                $order->vehicle_id = $vehicle->id;
                $order->garage_id = Auth::user()->fleet->garages()->first()->id;
                $order->creator_user_id = Auth::user()->id;
                $order->kms = $counter->type === 'kms' ? $valor : null;
                $order->work_hours_chassis = $counter->type === 'work_hours' && $counter->vehicle_category === 'chassis' ? $valor : null;
                $order->work_hours_equipment = $counter->type === 'work_hours' && $counter->vehicle_category === 'equipment' ? $valor : null;
                $order->save();

                foreach ($plan->operations as $operation) {
                    $order_operation = $order->operations()->save(new RepairOrderOperation([
                        'maintenance_plan_id' => $plan->id,
                        'maintenance_plan_name' => $plan->fullname,
                        'operation_attachment_file_id' => $operation->attachment_file_id,
                        'operation_family' => $operation->family?->name,
                        'operation_subfamily' => $operation->subfamily?->name,
                        'operation_name' => $operation->name,
                        'operation_description' => $operation->description,
                        'estimated_time_in_hours' => $operation->time_in_hours,
                    ]));
                }

                RapairOrderStateService::transit($order->id, RepairOrderState::FINISHED);
                Artisan::call("maintenance:sync {$order->vehicle->id}");
            }
        }
    }
}