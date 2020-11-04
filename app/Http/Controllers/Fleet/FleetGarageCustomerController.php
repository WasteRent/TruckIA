<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\CustomerRequest;
use App\Models\Garage;
use App\Models\Customer;
use App\Models\EnterpriseGroup;
use Illuminate\Http\Request;

class FleetGarageCustomerController extends Controller
{

    public function index(Request $request, Garage $garage)
    {
        $filters = $request->all();
        $customers_search = !empty($filters) ? Customer::filter($filters)->get() : [];

        return view('fleet.garages.customers.index', [
            'garage'=>$garage,
            'customers'=>$garage->customers,
            'enterprises' => EnterpriseGroup::all(),
            'customers_search' => $customers_search
        ]);
    }

    public function destroy(Garage $garage, Customer $customer)
    {
        $garage ->customers()->detach($customer);
        return redirect()->route('fleet.garages.customers.index', $garage)->with('success_message', 'El cliente fue desvinculado de este taller.');
    }

    public function store(Request $request, Garage $garage)
    {
        if ($garage->customers->contains($request->customer_id)) {
            return back()->with('error_message', 'Este cliente ya está asignado a este taller.');
        }
        $garage->customers()->attach($request->customer_id);
        $customer_fleet = Customer::find($request->customer_id);
        $customer_fleet->fleet_id = $garage->fleet_id;
        $customer_fleet->save();

        return redirect()->route('fleet.garages.customers.index', $garage)->with('success_message', 'Cliente añadido correctamente');
    }
}