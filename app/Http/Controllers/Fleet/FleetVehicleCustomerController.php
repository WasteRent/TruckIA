<?php

namespace App\Http\Controllers\Fleet;

use App\Events\VehicleReassgined;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\EnterpriseGroup;
use App\Models\Vehicle;
use App\Models\VehicleCustomerHistory;
use App\Models\VehicleState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetVehicleCustomerController extends Controller
{
    public function index(Request $request, Vehicle $vehicle)
    {
        $customers_search = ! empty($request->all()) ? Customer::filter($request->all())->where('fleet_id', Auth::user()->fleet->id)->get() : [];

        return view('fleet.vehicles.customers.index', [
            'vehicle' => $vehicle,
            'customers_search' => $customers_search,
            'enterprises' => EnterpriseGroup::where('fleet_id', Auth::user()->fleet->id),
        ]);
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        if ($request->customer_id == $vehicle->assigned_customer_id) {
            return back()->with('error_message', 'Este cliente ya está asignado al vehículo');
        }

        $vehicle->update(['assigned_customer_id' => $request->customer_id]);

        VehicleCustomerHistory::create([
            'vehicle_id' => $vehicle->id,
            'customer_id' => $request->customer_id,
        ]);

        $vehicle->changeState(VehicleState::RENTED);

        event(new VehicleReassgined($vehicle));

        return redirect()->route('fleet.vehicles.customers.index', $vehicle)
            ->with('success_message', 'Cliente añadido correctamente');
    }

    public function destroy(Vehicle $vehicle, Customer $customer)
    {
        $vehicle->update(['assigned_customer_id' => null]);

        $vehicle->changeState(VehicleState::AVAILABLE);

        return redirect()->route('fleet.vehicles.customers.index', $vehicle)
            ->with('success_message', 'Cliente eliminado correctamente');
    }
}
