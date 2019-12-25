<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GarageRequest;
use App\Models\Garage;
use App\User;

class AdminGarageController extends Controller
{

    public function index()
    {
        return view('admin.garages.index', [
            'garages' => Garage::all()
        ]);
    }

    public function create()
    {
        return view('admin.garages.create');
    }

    public function store(GarageRequest $request)
    {
        $user = User::create([
            'name'      => $request->name,
            'username'  => $request->email,
            'email'     => $request->email,
            'password'  => str_random(10),
            'role'      => 'garage'
        ]);

        $garage = new Garage($request->all());
        $garage->user_id = $user->id;
        $garage->save();

        return redirect()->route('admin.garages.index')->with('success_message', 'Taller creado');
    }

    public function show(Garage $garage)
    {
        return view('admin.garages.show', [
            'garage' => $garage
        ]);
    }

    public function edit(Garage $garage)
    {
        return view('admin.garages.edit', [
            'garage' => $garage
        ]);
    }

    public function update(GarageRequest $request, Garage $garage)
    {
        $garage->update($request->all());
        return redirect()->route('admin.garages.index')->with('success_message', 'Taller actualizado');
    }

    public function destroy(Garage $garage)
    {
        //
    }
}
