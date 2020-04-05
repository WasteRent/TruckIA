<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleEquipmentRequest;
use App\Models\Equipment;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Vehicle;

class FleetVehicleEquipmentController extends Controller
{

    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.equipments.index', [
            'vehicle' => $vehicle,
            'manufacturers' => Manufacturer::all(),
            'models' => Model::all()
        ]);
    }

    public function store(VehicleEquipmentRequest $request, Vehicle $vehicle)
    {
        $vehicle->equipments()->save(new Equipment($request->all()));
        return back()->with('success_message', 'Equipo creado');
    }

    public function update(VehicleEquipmentRequest $request, Vehicle $vehicle, Equipment $equipment)
    {
        $equipment->update($request->all());
        return back()->with('success_message', 'Equipo actualizado');
    }

    public function destroy(Vehicle $vehicle, Equipment $equipment)
    {
        $equipment->delete();
        return back()->with('success_message', 'Equipo eliminada');
    }
}
