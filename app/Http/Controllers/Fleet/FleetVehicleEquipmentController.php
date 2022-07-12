<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleEquipmentRequest;
use App\Models\Equipment;
use App\Models\File;
use App\Models\Manufacturer;
use App\Models\Vehicle;

class FleetVehicleEquipmentController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.equipments.index', [
            'vehicle' => $vehicle,
            'manufacturers' => Manufacturer::all(),
            'models' => collect([]),
        ]);
    }

    public function store(VehicleEquipmentRequest $request, Vehicle $vehicle)
    {
        $equipment = new Equipment($request->all());

        if ($request->picture) {
            $file = File::storeFile($request->picture, 'equipment');
            $equipment->picture_file_id = $file->id;
        }

        $vehicle->equipments()->save($equipment);

        return back()->with('success_message', 'Equipo creado');
    }

    public function edit(Vehicle $vehicle, Equipment $equipment)
    {
        return view('fleet.vehicles.equipments.edit', [
            'vehicle' => $vehicle,
            'equipment' => $equipment,
            'manufacturers' => Manufacturer::all(),
            'models' => $equipment->maker->models,
        ]);
    }

    public function update(VehicleEquipmentRequest $request, Vehicle $vehicle, Equipment $equipment)
    {
        if ($request->picture) {
            if ($equipment->picture) {
                $equipment->picture->removeFile();

                try {
                    $equipment->picture->delete();
                } catch (\Exception $e) {
                }
            }

            $file = File::storeFile($request->picture, 'equipment');
            $equipment->update(['picture_file_id' => $file->id]);
        }

        $equipment->update($request->all());

        return redirect()->route('fleet.vehicles.equipments.index', $vehicle)->with('success_message', 'Equipo actualizado');
    }

    public function destroy(Vehicle $vehicle, Equipment $equipment)
    {
        if ($equipment->picture) {
            $equipment->picture->removeFile();
        }

        $equipment->delete();

        return back()->with('success_message', 'Equipo eliminada');
    }
}
