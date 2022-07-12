<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Customer;
use App\User;

class FleetCustomerUserController extends Controller
{
    public function index(Customer $customer)
    {
        return view('fleet.customers.users.index', [
            'customer' => $customer,
            'users' => User::where([
                'role' => 'customer',
                'entity_relation_id' => $customer->id,
            ])->get(),
        ]);
    }

    public function store(StoreUserRequest $request, Customer $customer)
    {
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'is_active' => $request->boolean('is_active'),
            'role' => 'customer',
            'entity_relation_id' => $customer->id,
        ]);

        return back()->with('success_message', 'Usuario creado');
    }

    public function update(UpdateUserRequest $request, Customer $customer, User $user)
    {
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success_message', 'Usuario actualizado');
    }

    public function destroy(Customer $customer, User $user)
    {
        $user->delete();

        return back()->with('success_message', 'Usuario eliminado');
    }
}
