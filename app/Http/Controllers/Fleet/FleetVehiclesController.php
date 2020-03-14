<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetVehiclesController extends Controller
{
    public function index(Request $request)
    {
        $filters = Vehicle::filters($request->all());
        $vehicles = Auth::user()->fleet->vehicles()->where($filters)->get();

        return view('fleet.vehicles.index', [
            'vehicles' => $vehicles
        ]);
    }

    public function show(Vehicle $vehicle)
    {
        return view('fleet.vehicles.show', [
            'vehicle' => $vehicle
        ]);
    }
}
