<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GarageRequest;
use App\Models\Garage;
use App\Models\Manufacturer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminGarageController extends Controller
{

    public function index(Request $request)
    {
        $filters = Garage::filters($request->all());
        $garages = Garage::where($filters)->paginate();

        return view('admin.garages.index', [
            'garages' => $garages
        ]);
    }

    public function create()
    {
        return view('admin.garages.create', [
            'manufacturers' => Manufacturer::all()
        ]);
    }

    public function store(GarageRequest $request)
    {
        $user = User::create([
            'name'      => $request->name,
            'username'  => $request->garage_email,
            'email'     => $request->garage_email,
            'password'  => str_random(10),
            'role'      => 'garage',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
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
            'garage' => $garage,
            'manufacturers' => Manufacturer::all()
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
