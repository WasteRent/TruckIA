<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\VehicleCustomerHistory;
use Illuminate\Http\Request;

class FleetVehicleCustomerController extends Controller
{

    public function index(Request $request, Vehicle $vehicle)
    {
        $filters = Customer::filters($request->all());
        $customers_search = !empty($filters) ? Customer::where($filters)->get() : [];

        return view('fleet.vehicles.customers.index', [
            'vehicle' => $vehicle,
            'customers_search' => $customers_search
        ]);
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $vehicle->update(['assigned_customer_id' => $request->customer_id]);
        VehicleCustomerHistory::create([
            'vehicle_id' => $vehicle->id,
            'customer_id' => $request->customer_id
        ]);

        return redirect()->route('fleet.vehicles.customers.index', $vehicle)
            ->with('success_message', 'Cliente añadido correctamente');
    }

    public function destroy(Vehicle $vehicle, Customer $customer)
    {
        $vehicle->update(['assigned_customer_id' => null]);
        return redirect()->route('fleet.vehicles.customers.index', $vehicle)
            ->with('success_message', 'Cliente eliminado correctamente');
    }
}
