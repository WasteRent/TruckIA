<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleWorkCounterRequest;
use App\Models\MaintenancePlan;
use App\Models\Vehicle;
use App\Models\VehicleWorkCounter;
use Illuminate\Http\Request;

class FleetVehicleCounterController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.counters.index', [
            'vehicle' => $vehicle
        ]);
    }

    public function create(Vehicle $vehicle)
    {
        return view('fleet.vehicles.counters.create', ['vehicle' => $vehicle]);
    }

    public function store(VehicleWorkCounterRequest $request, Vehicle $vehicle)
    {
        $vehicle->counters()->save(new VehicleWorkCounter($request->all()));
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
                    'description' => $plan->fullname
                ]));
            }
            if ($plan->natural_hours > 0) {
                $vehicle->counters()->save(new VehicleWorkCounter([
                    'plan_id' => $plan->id,
                    'vehicle_category' => $plan->vehicle_category,
                    'max' => $plan->natural_hours,
                    'type' => 'natural_hours',
                    'description' => $plan->fullname
                ]));
            }
            if ($plan->work_hours > 0) {
                $vehicle->counters()->save(new VehicleWorkCounter([
                    'plan_id' => $plan->id,
                    'vehicle_category' => $plan->vehicle_category,
                    'max' => $plan->work_hours,
                    'type' => 'work_hours',
                    'description' => $plan->fullname
                ]));
            }
        }
    }

    public function edit(Vehicle $vehicle, VehicleWorkCounter $counter)
    {
        return view('fleet.vehicles.counters.edit', [
            'vehicle' => $vehicle,
            'counter' => $counter
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
