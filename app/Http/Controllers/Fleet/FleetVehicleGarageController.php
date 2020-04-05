<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Garage;
use App\Models\Manufacturer;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class FleetVehicleGarageController extends Controller
{

    public function index(Request $request, Vehicle $vehicle)
    {
        $filters = $request->all();
        $garages_search = !empty($filters) ? Garage::filter($filters)->get() : [];

        return view('fleet.vehicles.garages.index', [
            'vehicle' => $vehicle,
            'garages' => $vehicle->garages,
            'manufacturers' => Manufacturer::all(),
            'garages_search' => $garages_search
        ]);
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        if ($vehicle->garages->contains($request->garage_id)) {
            return back()->with('error_message', 'Este taller ya ha sido asignado al vehículo.');
        }

        $vehicle->garages()->attach($request->garage_id);

        return redirect()->route('fleet.vehicles.garages.index', $vehicle)
            ->with('success_message', 'Taller añadido correctamente');
    }


    public function destroy(Vehicle $vehicle, Garage $garage)
    {
        $vehicle->garages()->detach($garage);

        return redirect()->route('fleet.vehicles.garages.index', $vehicle)
            ->with('success_message', 'Taller eliminado correctamente');
    }
}
