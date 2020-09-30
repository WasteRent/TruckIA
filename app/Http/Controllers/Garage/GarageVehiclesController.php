<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Manufacturer;
use App\Models\Vehicle;
use App\Models\VehicleState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GarageVehiclesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->page) {
            session(['vehicle_page' => $request->page]);
        }
        
        if (!empty($request->all())) {
            session()->forget('vehicle_page');
        }

        if ($request->all()) {
            session(['filters' => $request->all()]);
        }

        $query = Vehicle::filter(session('filters') ?? []);
        if ($request->show == 'discharged') {
            $query = $query->whereNotNull('discharged_date');
        } else {
            $query = $query->whereNull('discharged_date');
        }

        $vehicles = $query->orderBy('plate')->paginate(40, ['*'], 'page', session('vehicle_page'));

        return view('garage.vehicles.index', [
            'vehicles' => $vehicles,
            'manufacturers' => Manufacturer::orderBy('name')->get(),
            'chassis_models' => Manufacturer::find($request->chassis_maker_id) ? Manufacturer::find($request->chassis_maker_id)->models->sortBy('name') : collect([]),
            'equipment_models' => Manufacturer::find($request->equipment_maker_id) ? Manufacturer::find($request->equipment_maker_id)->models->sortBy('name') : collect([]),
            'customers' => Customer::all(),
            'states' => VehicleState::all()
        ]);
    }

    public function show(Vehicle $vehicle)
    {
        return view('garage.vehicles.show', [
            'vehicle' => $vehicle
        ]);
    }
}
