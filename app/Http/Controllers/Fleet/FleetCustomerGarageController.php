<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Garage;
use App\Models\Manufacturer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetCustomerGarageController extends Controller
{

    public function index(Request $request, Customer $customer)
    {
        $filters = $request->all();
        $garages_search = !empty($filters) ? Garage::filter($filters)->where('fleet_id', Auth::user()->fleet->id)->get() : [];

        return view('fleet.customers.garages.index', [
            'customer' => $customer,
            'manufacturers' => Manufacturer::all(),
            'garages_search' => $garages_search
        ]);
    }

    public function store(Request $request, Customer $customer)
    {
        if ($customer->garages->contains($request->garage_id)) {
            return back()->with('error_message', 'Este taller ya ha sido asignado al cliente.');
        }

        $customer->garages()->attach($request->garage_id);

        return redirect()->route('fleet.customers.garages.index', $customer)
            ->with('success_message', 'Taller añadido correctamente');
    }


    public function destroy(Customer $customer, Garage $garage)
    {
        $customer->garages()->detach($garage);

        return redirect()->route('fleet.customers.garages.index', $customer)
            ->with('success_message', 'Taller eliminado correctamente');
    }
}
