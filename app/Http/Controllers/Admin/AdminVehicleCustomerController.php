<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class AdminVehicleCustomerController extends Controller
{

    public function index(Request $request, Vehicle $vehicle)
    {
        $filters = Customer::filters($request->all());
        $customers_search = !empty($filters) ? Customer::where($filters)->get() : [];

        return view('admin.vehicles.customers.index', [
            'vehicle' => $vehicle,
            'customers' => $vehicle->customers,
            'customers_search' => $customers_search
        ]);
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        if ($vehicle->customers->contains($request->customer_id)) {
            return back()->with('error_message', 'Este cliente ya ha sido asignado al vehículo.');
        }

        $vehicle->customers()->attach($request->customer_id);

        return redirect()->route('admin.vehicles.customers.index', $vehicle)
            ->with('success_message', 'Cliente añadido correctamente');
    }


    public function destroy(Vehicle $vehicle, Customer $customer)
    {
        $vehicle->customers()->detach($customer);

        return redirect()->route('admin.vehicles.customers.index', $vehicle)
            ->with('success_message', 'Cliente eliminado correctamente');
    }
}
