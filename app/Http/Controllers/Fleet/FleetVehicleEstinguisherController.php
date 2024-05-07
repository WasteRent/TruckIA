<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleEstinguisher;
use Illuminate\Http\Request;

class FleetVehicleEstinguisherController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.estinguishers.index', [
            'vehicle' => $vehicle,
        ]);
    }

    public function create(Vehicle $vehicle)
    {
        return view('fleet.vehicles.estinguishers.create', [
            'vehicle' => $vehicle,
        ]);
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $request->validate(['name' => 'required', 'expiration_date' => 'required|date']);

        $estinguisher = new VehicleEstinguisher($request->all());
        $vehicle->estinguishers()->save($estinguisher);

        return to_route('fleet.vehicles.estinguishers.index', $vehicle)->with('success_message', 'Extintor creado');
    }

    public function edit(Vehicle $vehicle, int $id)
    {
        return view('fleet.vehicles.estinguishers.edit', [
            'vehicle' => $vehicle,
            'estinguisher' => VehicleEstinguisher::findOrFail($id),
        ]);
    }

    public function update(Request $request, Vehicle $vehicle, int $id)
    {
        $request->validate(['name' => 'required', 'expiration_date' => 'required|date']);

        VehicleEstinguisher::findOrFail($id)->update($request->all());

        return to_route('fleet.vehicles.estinguishers.index', $vehicle)->with('success_message', 'Extintor actualizado');
    }

    public function destroy(Vehicle $vehicle, int $id)
    {
        VehicleEstinguisher::findOrFail($id)->delete();

        return to_route('fleet.vehicles.estinguishers.index', $vehicle)->with('success_message', 'Extintor eliminada');
    }
}
