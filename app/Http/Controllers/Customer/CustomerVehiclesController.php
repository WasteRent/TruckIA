<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\RepairOrder;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerVehiclesController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->username == 'CarlosC') { //ccebolla, debe ver todos los de tetma
            $tetmas = Fleet::find(1)->customers()->where('name', 'like', "%tetma%")->pluck('id');
            $vehicles = Vehicle::filter($request->all())
                        ->where('fleet_id', 1)
                        ->whereIn('assigned_customer_id', $tetmas)
                        ->paginate(40);
        }
        else {
           $vehicles = Vehicle::filter($request->all())
                       ->where('assigned_customer_id', Auth::user()->customer->id)
                       ->paginate(40);
        }


        return view('customer.vehicles.index', [
            'vehicles' => $vehicles,
            'manufacturers' => Manufacturer::all(),
            'models' => Model::all(),
        ]);
    }

    public function show(Request $request, Vehicle $vehicle)
    {
        ini_set('memory_limit', '-1');

        $filters = RepairOrder::filters($request->all());

        return view('customer.vehicles.show', [
            'vehicle' => $vehicle,
            'repair_orders' => RepairOrder::where($filters)->latest()->get(),
        ]);
    }
}
