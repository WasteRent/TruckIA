<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RepairOrder;

class CustomerVehiclesController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->id() == 'CarlosC') { //ccebolla, debe ver todos los de tetma
            $tetmas = auth()->user()->customers()->where('name', 'like', "%tetma%")->pluck('id');
            $vehicles = Vehicle::filter($request->all())
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
        $filters = RepairOrder::filters($request->all());

        return view('customer.vehicles.show', [
            'vehicle' => $vehicle,
            'repair_orders' => RepairOrder::where($filters)->latest()->get(),
        ]);
    }
}
