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
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show(Vehicle $vehicle)
    {
        return view('admin.vehicles.show', [
            'vehicle' => $vehicle
        ]);
    }


    public function edit(Vehicle $vehicle)
    {
        //
    }


    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->all());
        return back()->with('success_message', 'Vehículo actualizado');
    }


    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
