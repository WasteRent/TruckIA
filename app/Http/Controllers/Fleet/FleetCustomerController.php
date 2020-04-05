<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\CustomerRequest;
use App\Models\Customer;
use App\Models\EnterpriseGroup;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FleetCustomerController extends Controller
{

    public function index(Request $request)
    {
        $filters = Customer::filters($request->all());
        $customers = Customer::where($filters)->paginate();

        return view('fleet.customers.index', [
            'customers' => $customers
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
        $user = User::create([
            'name'      => $request->name,
            'username'  => $request->email1,
            'email'     => $request->email1,
            'password'  => str_random(10),
            'role'      => 'customer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $customer = new Customer($request->all());
        $customer->user_id = $user->id;
        $customer->save();

        return redirect()->route('fleet.customers.index')->with('success_message', 'Cliente creado');
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
