<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\GarageRequest;
use App\Models\Garage;
use App\Models\Manufacturer;
use App\User;
use Illuminate\Http\Request;

class FleetGarageController extends Controller
{

    public function index(Request $request)
    {
        $garages = Garage::filter($request->all())->paginate();
        return view('fleet.garages.index', [
            'garages' => $garages,
            'manufacturers' => Manufacturer::all()
        ]);
    }

    public function create()
    {
        return view('fleet.garages.create', [
            'manufacturers' => Manufacturer::all()
        ]);
    }

    public function store(GarageRequest $request)
    {
        $user = User::create([
            'name'      => $request->name,
            'username'  => $request->garage_email,
            'email'     => $request->garage_email,
            'password'  => bcrypt(str_random(10)),
            'role'      => 'garage'
        ]);

        $garage = new Garage($request->all());
        $garage->user_id = $user->id;
        $garage->save();

        return redirect()->route('fleet.garages.index')->with('success_message', 'Taller creado');
    }

    public function show(Garage $garage)
    {
        return view('fleet.garages.show', [
            'garage' => $garage
        ]);
    }

    public function edit(Garage $garage)
    {
        return view('fleet.garages.edit', [
            'garage' => $garage,
            'manufacturers' => Manufacturer::all()
        ]);
    }

    public function update(GarageRequest $request, Garage $garage)
    {
        $garage->update($request->all());
        $garage->user()->update([
            'username' => $request->garage_email,
            'email' => $request->garage_email
        ]);
        return back()->with('success_message', 'Taller actualizado');
    }

    public function destroy(Garage $garage)
    {
        //
    }
}
