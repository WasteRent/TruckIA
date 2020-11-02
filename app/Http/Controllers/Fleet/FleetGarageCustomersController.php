<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Garage;

class FleetGarageCustomersController extends Controller
{

    public function index(Garage $garage)
    {
        return view('fleet.garages.customers.index', [
            'garage' => $garage,
            'customers' => $garage -> customers
        ]);
    }

    public function destroy(Garage $garage, Customer $customer)
    {
        $customer->delete();
        return back()->with('success_message', 'Cliente eliminado');
    }

    public function edit(Garage $garage, Customer $customer)
    {
        return view('fleet.garages.customers.edit', [
            'garage' => $garage,
            'customers' => $customer
        ]);
    }
   
   /* public function update(UpdateCustomerRequest $request, Garage $garage, Customer $customer)
    {
        $customer->update([
            'name'      => $request->name,
            'notifications_email'  => $request->notifications_email,
            'address'     => $request->address,
            'state' => $request->state,
            'province'     => $request->province,
            'zip'     => $request->zip,
            'contact1'     => $request->contact1,
            'email1'     => $request->email1,
            'phone1'     => $request->phone1,
        ]);
        return back()->with('success_message', 'Usuario actualizado');
    } */

}
