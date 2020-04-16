<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleRequest;
use App\Models\Customer;
use App\Models\Fleet;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetVehicleController extends Controller
{

    public function index(Request $request)
    {
        $filters = Vehicle::filters($request->all());
        $vehicles = Vehicle::where($filters)->whereNull('discharged_at')->orderBy('plate')->paginate(40);

        return view('fleet.vehicles.index', [
            'vehicles' => $vehicles,
            'manufacturers' => Manufacturer::all(),
            'models' => Manufacturer::find($request->chassis_maker_id) ? Manufacturer::find($request->chassis_maker_id)->models : collect([]),
            'customers' => Customer::all()
        ]);
    }

    public function create()
    {
        return view('fleet.vehicles.create', [
            'fleets' => Fleet::all(),
            'manufacturers' => Manufacturer::all(),
            'models' => Model::all(),
            'types' => VehicleType::all()
        ]);
    }

    public function store(VehicleRequest $request)
    {
        $vehicle = new Vehicle($request->all());
        $vehicle->save();
        return redirect()->route('fleet.vehicles.edit', $vehicle)->with('success_message', 'Vehículo creado');
    }

    public function show(Vehicle $vehicle)
    {
        $next = Vehicle::whereNull('discharged_at')
                    ->where('id', '!=', $vehicle->id)
                    ->orderBy('plate')
                    ->get()
                    ->random(1)
                    ->first();

        return view('fleet.vehicles.show', [
            'vehicle' => $vehicle,
            'next_vehicle_url' => route('fleet.vehicles.edit', $next)
        ]);
    }

    public function edit(Vehicle $vehicle)
    {
        $next = Vehicle::whereNull('discharged_at')
                    ->where('id', '!=', $vehicle->id)
                    ->orderBy('plate')
                    ->get()
                    ->random(1)
                    ->first();

        return view('fleet.vehicles.edit', [
            'vehicle' => $vehicle,
            'manufacturers' => Manufacturer::all(),
            'models' => $vehicle->chassisMaker->models,
            'types' => VehicleType::all(),
            'next_vehicle_url' => route('fleet.vehicles.edit', $next)
        ]);
    }

    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->all());
        return back()->with('success_message', 'Vehículo actualizado');
    }

    public function destroy(Vehicle $vehicle)
    {
        try {
            $vehicle->delete();
        } catch (\Exception $e) {
            return back()->with('error_message', 'Este vehículo tiene ordenes de reparación asociadas.');
        }
        
        return back()->with('success_message', 'Vehículo eliminado');
    }
}
