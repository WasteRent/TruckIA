<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class FleetVehicleCounterController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.counters.index', [
            'vehicle' => $vehicle
        ]);
    }
}
