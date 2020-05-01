<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class SearchVehicleController extends Controller
{
    public function index(Request $request)
    {
        $filters = Vehicle::filters($request->all());
        $vehicles = Vehicle::where($filters)->get();

        return $vehicles->map(function ($vehicle) {
            $vehicle->type = optional($vehicle->type)->name;
            return $vehicle;
        });
    }
}
