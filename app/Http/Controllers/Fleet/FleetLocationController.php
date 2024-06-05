<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\VehicleLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetLocationController extends Controller
{
    public function index(Request $request)
    {
        $locations = VehicleLocation::filter($request->all())
                        ->where('fleet_id', Auth::user()->fleet->id)
                        ->latest()
                        ->paginate(40);

        return view('fleet.vehicles.locations.index', [
            'locations' => $locations,
        ]);
    }

    public function create() {
        return view('fleet.vehicles.locations.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required']);
        $data['fleet_id'] = auth()->user()->fleet->id;
        VehicleLocation::create($data);

        return to_route('fleet.locations.index')->with('success_message', 'Ubicación creada');
    }

    public function edit(VehicleLocation $location) {
        return view('fleet.vehicles.locations.edit', [
            'location' => $location,
        ]);
    }

    public function update(Request $request, VehicleLocation $location)
    {
        $data = $request->validate(['name' => 'required']);
        $location->update($data);

        return to_route('fleet.locations.index')->with('success_message', 'Ubicación actualizada');
    }
}
