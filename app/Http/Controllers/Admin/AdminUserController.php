<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Fleet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.users.index', [
            'users' => User::filter($request->toArray())->paginate(),
        ]);
    }

    public function create()
    {
        return view('admin.users.create', [
            'fleet' => Fleet::all(),
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->input('password')),
            'email' => $request->email,
            'is_active' => $request->boolean('is_active'),
            'is_readonly' => $request->boolean('is_readonly'),
            'role' => $request->role,
            'entity_relation_id' => $request->entity_relation_id,
        ]);

        return redirect()->route('admin.users.index')->with('success_message', 'Usuario creado');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
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
            'username' => $request->username,
            'email' => $request->email,
            'is_active' => $request->boolean('is_active'),
            'is_readonly' => $request->boolean('is_readonly'),
        ]);

        return redirect()->route('admin.users.index')->with('success_message', 'Usuario actualizado');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success_message', 'Usuario eliminado');
    }
}
