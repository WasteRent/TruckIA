<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleRequest;
use App\Models\Customer;
use App\Models\Fleet;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Vehicle;
use App\Models\VehicleState;
use App\Models\VehicleStateHistory;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetVehicleController extends Controller
{

    public function index(Request $request)
    {
        if ($request->page) {
            session(['vehicle_page' => $request->page]);
        }
        
        $filters = Vehicle::filters($request->all());

        if (!empty($filters)) {
            session()->forget('vehicle_page');
        }

        $vehicles = Vehicle::where($filters)
                        ->whereNull('discharged_date')
                        ->orderBy('plate')
                        ->paginate(40, ['*'], 'page', session('vehicle_page'));

        return view('fleet.vehicles.index', [
            'vehicles' => $vehicles,
            'manufacturers' => Manufacturer::all(),
            'models' => Manufacturer::find($request->chassis_maker_id) ? Manufacturer::find($request->chassis_maker_id)->models : collect([]),
            'customers' => Customer::all(),
            'states' => VehicleState::all()
        ]);
    }

    public function create()
    {
        return view('fleet.vehicles.create', [
            'fleets' => Fleet::all(),
            'manufacturers' => Manufacturer::all(),
            'models' => Model::all(),
            'types' => VehicleType::orderBy('name')->get(),
            'states' => VehicleState::orderBy('name')->get()
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
        return view('fleet.vehicles.show', [
            'vehicle' => $vehicle
        ]);
    }

    public function edit(Vehicle $vehicle)
    {
        return view('fleet.vehicles.edit', [
            'vehicle' => $vehicle,
            'manufacturers' => Manufacturer::all(),
            'models' => $vehicle->chassisMaker ? $vehicle->chassisMaker->models:collect([]),
            'types' => VehicleType::orderBy('name')->get(),
            'states' => VehicleState::orderBy('name')->get()
        ]);
    }

    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        if ($request->state_id && ($vehicle->state_id != $request->state_id)) {
            $vehicle->changeState($request->state_id);
        } elseif (empty($vehicle->discharged_date) && $request->discharged_date) {
            $vehicle->changeState(VehicleState::DISCHARGED);
        }

        $data = $request->all();
        unset($data['state_id']);
        $vehicle->update($data);

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
