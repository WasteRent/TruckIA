<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Fleet;
use App\User;

class FleetUserController extends Controller
{
    public function index()
    {
        $users = User::where([
            'role' => 'fleet',
            'entity_relation_id' => Fleet::first()->id
        ])->paginate();

        return view('fleet.users.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return view('fleet.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        User::create([
            'name'      => $request->name,
            'username'  => $request->username,
            'password'  => bcrypt($request->password),
            'email'     => $request->email,
            'is_active' => $request->boolean('is_active'),
            'role' => 'fleet',
            'entity_relation_id' => Fleet::first()->id
        ]);
        return redirect()->route('fleet.users.index')->with('success_message', 'Usuario creado');
    }

    public function edit(User $user)
    {
        return view('fleet.users.edit', [
            'user' => $user
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'name'      => $request->name,
            'username'  => $request->username,
            'email'     => $request->email,
            'is_active' => $request->boolean('is_active')
        ]);

        return redirect()->route('fleet.users.index')->with('success_message', 'Usuario actualizado');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success_message', 'Usuario eliminado');
    }
}
