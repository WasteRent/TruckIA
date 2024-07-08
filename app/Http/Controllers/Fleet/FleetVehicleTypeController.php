<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class FleetVehicleTypeController extends Controller
{
    public function index(Request $request)
    {
        $vehicle_types = VehicleType::orderBy('name')->get();

        return view('fleet.vehicle_types.index', [
            'vehicle_types' => $vehicle_types,
        ]);
    }

    public function create(Request $request)
    {
        return view('fleet.vehicle_types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:vehicle_types,name'
        ]);

        VehicleType::create($data);

        return to_route('fleet.vehicle-types.index')->with('success_message', 'Tipo creado');
    }
}
