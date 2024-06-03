<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Customer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FleetUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::filter($request->toArray())->where([
            'role' => 'fleet',
            'entity_relation_id' => Auth::user()->fleet->id,
        ])->paginate();

        return view('fleet.users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return view('fleet.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->input('password')),
            'email' => $request->email,
            'is_active' => $request->boolean('is_active'),
            'is_readonly' => $request->boolean('is_readonly'),
            'job' => $request->job,
            'role' => 'fleet',
            'entity_relation_id' => Auth::user()->fleet->id,
            'allowed_schedule' => $request->allowed_schedule,
        ]);

        if (Customer::where('fleet_id', $user->fleet->id)->count() == count($request->allowed_customer_id)) {
            $user->allowedCustomers()->delete();
        } else {
            $user->allowedCustomers()->sync($request->allowed_customer_id);
        }

        return redirect()->route('fleet.users.index')->with('success_message', 'Usuario creado');
    }

    public function edit(User $user)
    {
        return view('fleet.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request->password) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        $user->update([
            'name' => $request->name,
            'is_active' => $request->boolean('is_active'),
            'is_readonly' => $request->boolean('is_readonly'),
            'job' => $request->job,
            'allowed_schedule' => $request->allowed_schedule,
        ]);

        if ($request->allowed_customer_id == null || Customer::where('fleet_id', $user->fleet->id)->count() == count($request->allowed_customer_id)) {
            $user->allowedCustomers()->sync([]);
        } else {
            $user->allowedCustomers()->sync($request->allowed_customer_id);
        }

        if ($request->user_fleets) {
            $user->allowedFleets()->sync(array_keys($request->user_fleets));
        }

        return redirect()->route('fleet.users.index')->with('success_message', 'Usuario actualizado');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success_message', 'Usuario eliminado');
    }
}
