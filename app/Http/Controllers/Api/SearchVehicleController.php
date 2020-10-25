<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchVehicleController extends Controller
{
    public function index(Request $request)
    {
        // if ($request->garage_id) {
        //     $vehicles = Vehicle::filter($request->all())
        //             ->join('customers', 'vehicles.assigned_customer_id', 'customers.id')
        //             ->join('customer_garages', 'customers.id', 'customer_garages.customer_id')
        //             ->where(['customer_garages.garage_id' => $request->garage_id])
        //             ->get();
        // } else {
            $vehicles = Vehicle::filter($request->all())->where('fleet_id', Auth::user()->fleet->id)->get();
        //}

        return $vehicles->map(function ($vehicle) {
            $vehicle->type = optional($vehicle->type)->name;
            return $vehicle;
        });
    }
}
