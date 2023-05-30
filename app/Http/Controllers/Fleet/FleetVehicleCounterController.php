<?php

namespace App\Http\Controllers\Fleet;

use App\Events\MaintenanceUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleWorkCounterRequest;
use App\Models\MaintenancePlan;
use App\Models\MaintenancePlanOperation;
use App\Models\Vehicle;
use App\Models\VehicleWorkCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FleetVehicleCounterController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        $fleet = Auth::user()->fleet;

        return view('fleet.vehicles.counters.index', [
            'vehicle' => $vehicle,
            'fleet' => $fleet,
        ]);
    }

    public function create(Vehicle $vehicle)
    {
        return view('fleet.vehicles.counters.create', ['vehicle' => $vehicle]);
    }

    public function store(VehicleWorkCounterRequest $request, Vehicle $vehicle)
    {
        try {
            DB::beginTransaction();

            //Create custom plan
            $plan_data = [
                'manufacturer_id' => $vehicle->chassis_maker_id,
                'model_id' => $vehicle->chassis_model_id,
                'version_id' => $vehicle->chassis_version_id,
                'name' => "[". auth()->user()->fleet->name. "] {$request->description}",
                'power_kw' => $vehicle->power_kw,
                'euro' => $vehicle->euro,
                'vehicle_category' => $request->vehicle_category
            ];

            if ($request->type == 'work_hours') {
                $plan_data['work_hours'] = $request->max;
            } elseif ($request->type == 'natural_hours') {
                $plan_data['natural_hours'] = $request->max;
            } elseif ($request->type == 'kms') {
                $plan_data['kms'] = $request->max;
            }

            $plan = MaintenancePlan::create($plan_data);
            
            //Create operations
            foreach ($request->operations as $operation) {
                if ($operation) {
                    MaintenancePlanOperation::create([
                        'maintenance_plan_id' => $plan->id,
                        'name' => $operation
                    ]);
                }
            }

            // Attach plan to fleet
            auth()->user()->fleet->customPlans()->attach($plan);

            //Create counter
            $data = $request->toArray();
            $data['plan_id'] = $plan->id;
            $vehicle->counters()->save(new VehicleWorkCounter($data));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('fleet.vehicles.counters.index', $vehicle)->with('success_message', 'Contador creado');
    }

    public function storeFromPlan(Request $request, Vehicle $vehicle)
    {
        foreach ($request->plans as $plan_id) {
            $plan = MaintenancePlan::findOrFail($plan_id);

            if ($plan->kms > 0) {
                $vehicle->counters()->save(new VehicleWorkCounter([
                    'plan_id' => $plan->id,
                    'vehicle_category' => $plan->vehicle_category,
                    'max' => $plan->kms,
                    'type' => 'kms',
                    'description' => $plan->fullname,
                ]));
            }
            if ($plan->natural_hours > 0) {
                $vehicle->counters()->save(new VehicleWorkCounter([
                    'plan_id' => $plan->id,
                    'vehicle_category' => $plan->vehicle_category,
                    'max' => $plan->natural_hours,
                    'type' => 'natural_hours',
                    'description' => $plan->fullname,
                ]));
            }
            if ($plan->work_hours > 0) {
                $vehicle->counters()->save(new VehicleWorkCounter([
                    'plan_id' => $plan->id,
                    'vehicle_category' => $plan->vehicle_category,
                    'max' => $plan->work_hours,
                    'type' => 'work_hours',
                    'description' => $plan->fullname,
                ]));
            }
            else if ($plan->can_hours > 0) {
                $vehicle->counters()->save(new VehicleWorkCounter([
                    'plan_id' => $plan->id,
                    'vehicle_category' => $plan->vehicle_category,
                    'max' => $plan->can_hours,
                    'type' => 'work_hours',
                    'description' => $plan->fullname,
                ]));
            }
        }

        event(new MaintenanceUpdated($vehicle->id));
    }

    public function edit(Vehicle $vehicle, VehicleWorkCounter $counter)
    {
        return view('fleet.vehicles.counters.edit', [
            'vehicle' => $vehicle,
            'counter' => $counter,
        ]);
    }

    public function update(VehicleWorkCounterRequest $request, Vehicle $vehicle, VehicleWorkCounter $counter)
    {
        $counter->update($request->all());

        return redirect()->route('fleet.vehicles.counters.index', $vehicle)->with('success_message', 'Contador actualizado');
    }

    public function reset(Vehicle $vehicle, VehicleWorkCounter $counter)
    {
        $counter->reset();

        return redirect()->route('fleet.vehicles.counters.index', $vehicle)->with('success_message', 'Contador reiniciado');
    }

    public function destroy(Vehicle $vehicle, VehicleWorkCounter $counter)
    {
        $counter->delete();

        return back()->with('success_message', 'Contador eliminado');
    }
}
