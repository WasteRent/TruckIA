<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GarageVehiclesController extends Controller
{
    public function index(Request $request)
    {
        $filters = Vehicle::filters($request->all());

        $vehicles = Vehicle::query()
                ->join('customers', 'vehicles.assigned_customer_id', 'customers.id')
                ->join('customer_garages', 'customers.id', 'customer_garages.customer_id')
                ->where(['customer_garages.garage_id' => Auth::user()->garage->id])
                ->where($filters)
                ->paginate(40);

        return view('garage.vehicles.index', [
            'vehicles' => $vehicles,
            'manufacturers' => Manufacturer::all(),
            'models' => Manufacturer::find($request->chassis_maker_id) ? Manufacturer::find($request->chassis_maker_id)->models : collect([]),
        ]);
    }

    public function show(Vehicle $vehicle)
    {
        return view('garage.vehicles.show', [
            'vehicle' => $vehicle
        ]);
    }
}
