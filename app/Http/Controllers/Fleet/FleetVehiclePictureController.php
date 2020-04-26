<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehiclePictureRequest;
use App\Models\File;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FleetVehiclePictureController extends Controller
{

    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.pictures.index', [
            'vehicle' => $vehicle
        ]);
    }

    public function update(Request $request, Vehicle $vehicle, int $file_id)
    {
        if ($request->cover) {
            $file = File::findOrFail($file_id);

            foreach ($vehicle->pictures as $picture) {
                $vehicle->pictures()->updateExistingPivot($picture->id, ['cover' => 0]);
            }

            $vehicle->pictures()->updateExistingPivot($file->id, ['cover' => 1]);
        }

        return back()->with('success_message', 'Portada actualizada');
    }

    public function store(VehiclePictureRequest $request, Vehicle $vehicle)
    {
        $file = File::storeFile($request->file, 'Foto');

        $vehicle->pictures()->attach($file);

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
