<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleFileRequest;
use App\Models\File;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Storage;

class FleetVehicleFileController extends Controller
{

    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.files.index', [
            'vehicle' => $vehicle
        ]);
    }

    public function store(VehicleFileRequest $request, Vehicle $vehicle)
    {
        $request->file->store('truckts/mantenimientos/files');

        $file = new File([
            'description' => $request->description,
            'filename' => $request->file->hashName(),
            'content_type' => $request->file->getMimeType(),
            'size' => $request->file->getSize()
        ]);
        $file->save();

        $vehicle->files()->attach($file);

        Storage::setVisibility($file->getPath(), 'public');

        return back()->with('success_message', 'Archivo añadido');
    }

    public function destroy(Vehicle $vehicle, File $file)
    {
        Storage::delete($file->getPath());
        $vehicle->files()->detach($file);
        $file->delete();
        return back()->with('success_message', 'Archivo eliminado');
    }
}
