<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleWorkCounterRequest;
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

    public function destroy(Vehicle $vehicle, VehicleWorkCounter $counter)
    {
        $counter->delete();
        return back()->with('success_message', 'Contador eliminado');
    }
}
