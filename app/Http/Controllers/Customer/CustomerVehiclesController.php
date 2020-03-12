<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class CustomerVehiclesController extends Controller
{
    public function index(Request $request)
    {
        $filters = Vehicle::filters($request->all());
        $vehicles = Vehicle::where($filters)->get();

        return view('customer.vehicles.index', [
            'vehicles' => $vehicles
        ]);
    }

    public function show(Vehicle $vehicle)
    {
        return view('customer.vehicles.show', [
            'vehicle' => $vehicle
        ]);
    }
}
