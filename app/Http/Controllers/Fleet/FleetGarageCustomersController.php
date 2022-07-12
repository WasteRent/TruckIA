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
            'customers' => $garage->customers,
        ]);
    }

    public function destroy(Garage $garage, Customer $customer)
    {
        $garage->customers()->detach($customer);

        return back()->with('success_message', 'Relación eliminada');
    }
}
