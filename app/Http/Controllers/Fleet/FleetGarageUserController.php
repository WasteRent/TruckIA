<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Garage;
use App\User;
use Illuminate\Support\Str;

class FleetGarageUserController extends Controller
{
    public function index(Garage $garage)
    {
        return view('fleet.garages.users.index', [
            'garage' => $garage,
            'users' => User::where([
                'role' => 'garage',
                'entity_relation_id' => $garage->id,
            ])->get(),
        ]);
    }

    public function store(StoreUserRequest $request, Garage $garage)
    {
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'email' => $request->email ?? Str::random(20),
            'is_active' => $request->boolean('is_active'),
            'role' => 'garage',
            'entity_relation_id' => $garage->id,
            'job' => 'mechanic',
        ]);

        return back()->with('success_message', 'Usuario creado');
    }

    public function update(UpdateUserRequest $request, Garage $garage, User $user)
    {
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success_message', 'Usuario actualizado');
    }

    public function destroy(Garage $garage, User $user)
    {
        $user->delete();

        return back()->with('success_message', 'Usuario eliminado');
    }
}
