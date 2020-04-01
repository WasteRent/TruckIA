<?php

namespace App\Http\Controllers\Admin;

use App\Equipment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EquipmentRequest;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Vehicle;

class AdminVehicleEquipmentController extends Controller
{

    public function index(Vehicle $vehicle)
    {
        return view('admin.vehicles.equipments.index', [
            'vehicle' => $vehicle,
            'manufacturers' => Manufacturer::all(),
            'models' => Model::all()
        ]);
    }

    public function store(EquipmentRequest $request, Vehicle $vehicle)
    {
        $vehicle->equipments()->save(new Equipment($request->all()));
        return back()->with('success_message', 'Equipo creado');
    }

    public function update(EquipmentRequest $request, Vehicle $vehicle, Equipment $equipment)
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
