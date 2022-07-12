<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleFileRequest;
use App\Models\File;
use App\Models\Vehicle;

class FleetVehicleFileController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        $vehicle_models = collect([$vehicle->chassisModel]);

        foreach ($vehicle->equipments as $equipment) {
            $vehicle_models->push($equipment->model);
        }

        return view('fleet.vehicles.files.index', [
            'vehicle' => $vehicle,
            'vehicle_models' => $vehicle_models,
        ]);
    }

    public function store(VehicleFileRequest $request, Vehicle $vehicle)
    {
        $file = File::storeFile($request->file, $request->description);

        $vehicle->files()->attach($file);

        return back()->with('success_message', 'Archivo añadido');
    }

    public function destroy(Vehicle $vehicle, File $file)
    {
        $file->removeFile();
        $vehicle->files()->detach($file);
        $file->delete();

        return back()->with('success_message', 'Archivo eliminado');
    }
}
