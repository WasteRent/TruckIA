<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class FleetCustomerVehicleController extends Controller
{
    public function index(Customer $customer)
    {
        return view('fleet.customers.vehicles.index', [
            'customer' => $customer,
        ]);
    }
}
