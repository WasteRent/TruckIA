<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Garage;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class AdminVehicleGarageController extends Controller
{

    public function index(Request $request, Vehicle $vehicle)
    {
        $filters = Garage::filters($request->all());
        $garages_search = Garage::where($filters)->get();

        return view('admin.vehicles.garages.index', [
            'vehicle' => $vehicle,
            'garages' => $vehicle->garages,
            'garages_search' => $garages_search
        ]);
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        if ($vehicle->garages->contains($request->garage_id)) {
            return back()->with('error_message', 'Este taller ya ha sido asignado al vehículo.');
        }

        $vehicle->garages()->attach($request->garage_id);

        return redirect()->route('admin.vehicles.garages.index', $vehicle)
            ->with('success_message', 'Taller añadido correctamente');
    }


    public function destroy(Vehicle $vehicle, Garage $garage)
    {
        $vehicle->garages()->detach($garage);

        return redirect()->route('admin.vehicles.garages.index', $vehicle)
            ->with('success_message', 'Taller eliminado correctamente');
    }
}
