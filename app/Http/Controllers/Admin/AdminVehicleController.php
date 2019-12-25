<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VehicleRequest;
use App\Models\Vehicle;

class AdminVehicleController extends Controller
{

    public function index()
    {
        return view('admin.vehicles.index', [
            'vehicles' => Vehicle::all()
        ]);
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(VehicleRequest $request)
    {
        $vehicle = new Vehicle($request->all());
        $vehicle->save();
        return redirect()->route('admin.vehicles.index')->with('success_message', 'Vehículo creado');
    }

    public function show(Vehicle $vehicle)
    {
        return view('admin.vehicles.show', [
            'vehicle' => $vehicle
        ]);
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', [
            'vehicle' => $vehicle
        ]);
    }

    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->all());
        return redirect()->route('admin.vehicles.index')->with('success_message', 'Vehículo actualizado');
    }

    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
