<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\CustomerRequest;
use App\Models\Customer;
use App\Models\EnterpriseGroup;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FleetCustomerController extends Controller
{

    public function index(Request $request)
    {
        $filters = Customer::filters($request->all());
        $customers = Customer::where($filters)->where('fleet_id', Auth::user()->fleet->id)->paginate();

        return view('fleet.customers.index', [
            'customers' => $customers,
            'enterprises' => EnterpriseGroup::where('fleet_id', Auth::user()->fleet->id)->get()
        ]);
    }

    public function create()
    {
        return view('fleet.customers.create', [
            'enterprises' => EnterpriseGroup::where('fleet_id', Auth::user()->fleet->id)->get()
        ]);
    }

    public function store(CustomerRequest $request)
    {
        try {
            DB::beginTransaction();
            $customer = new Customer($request->all());
            $customer->fleet_id = Auth::user()->fleet->id;
            $customer->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error_message', 'Ha ocurrido un error');
        }

        return redirect()->route('fleet.customers.edit', $customer)->with('success_message', 'Cliente creado');
    }


    public function edit(Customer $customer)
    {
        return view('fleet.customers.edit', [
            'customer' => $customer,
            'enterprises' => EnterpriseGroup::where('fleet_id', Auth::user()->fleet->id)->get()
        ]);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
        return redirect()->route('fleet.customers.index')->with('success_message', 'Cliente actualizado');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return back()->with('success_message', 'Cliente eliminado');
    }
}
