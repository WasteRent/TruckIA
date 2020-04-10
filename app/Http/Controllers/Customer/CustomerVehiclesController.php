<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerVehiclesController extends Controller
{
    public function index(Request $request)
    {
        $filters = Vehicle::filters($request->all());
        $vehicles = Auth::user()->customer->vehicles()->where($filters)->paginate(40);

        return view('customer.vehicles.index', [
            'vehicles' => $vehicles,
            'manufacturers' => Manufacturer::all(),
            'models' => Model::all()
        ]);
    }

    public function show(Vehicle $vehicle)
    {
        return view('customer.vehicles.show', [
            'vehicle' => $vehicle
        ]);
    }
}
