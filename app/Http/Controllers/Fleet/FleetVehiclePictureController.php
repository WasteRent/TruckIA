<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehiclePictureRequest;
use App\Models\File;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Storage;

class FleetVehiclePictureController extends Controller
{

    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.pictures.index', [
            'vehicle' => $vehicle
        ]);
    }

    public function store(VehiclePictureRequest $request, Vehicle $vehicle)
    {
        $request->file->store('truckts/mantenimientos/files');

        $file = new File([
            'description' => 'Foto',
            'filename' => $request->file->hashName(),
            'content_type' => $request->file->getMimeType()
        ]);
        $file->save();

        $vehicle->pictures()->attach($file);

        Storage::setVisibility($file->getPath(), 'public');

        return back()->with('success_message', 'Fota añadida');
    }

    public function destroy(Vehicle $vehicle, int $file_id)
    {
        $file = File::findOrFail($file_id);
        Storage::delete($file->getPath());
        $vehicle->pictures()->detach($file);
        $file->delete();
        return back()->with('success_message', 'Foto eliminada');
    }
}
