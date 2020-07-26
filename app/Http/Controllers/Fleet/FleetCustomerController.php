<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\CustomerRequest;
use App\Models\Customer;
use App\Models\EnterpriseGroup;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FleetCustomerController extends Controller
{

    public function index(Request $request)
    {
        if ($request->all()) {
            session(['filters' => $request->all()]);
        }

        $filters = Customer::filters(session('filters'));
        $customers = Customer::where($filters)->paginate();

        return view('fleet.customers.index', [
            'customers' => $customers,
            'enterprises' => EnterpriseGroup::all()
        ]);
    }

    public function create()
    {
        return view('fleet.customers.create', [
            'enterprises' => EnterpriseGroup::all()
        ]);
    }

    public function store(CustomerRequest $request)
    {
        try {
            DB::beginTransaction();
            $customer = new Customer($request->all());
            $customer->save();

            User::create([
                'name'      => $request->name,
                'username'  => $request->email1,
                'email'     => $request->email1,
                'password'  => bcrypt(str_random(10)),
                'role'      => 'customer',
                'entity_relation_id' => $customer->id
            ]);
            
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
            'enterprises' => EnterpriseGroup::all()
        ]);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
        return redirect()->route('fleet.customers.index')->with('success_message', 'Cliente actualizado');
    }
}
