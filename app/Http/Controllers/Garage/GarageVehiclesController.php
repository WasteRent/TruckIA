<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GarageVehiclesController extends Controller
{
    public function index(Request $request)
    {
        $filters = Vehicle::filters($request->all());
        $vehicles = Auth::user()->garage->vehicles()->where($filters)->paginate(40);

        return view('garage.vehicles.index', [
            'vehicles' => $vehicles
        ]);
    }

    public function show(Vehicle $vehicle)
    {
        return view('garage.vehicles.show', [
            'vehicle' => $vehicle
        ]);
    }
}
