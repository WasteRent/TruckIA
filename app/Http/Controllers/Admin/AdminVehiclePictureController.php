<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PictureRequest;
use App\Models\File;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Storage;

class AdminVehiclePictureController extends Controller
{

    public function index(Vehicle $vehicle)
    {
        return view('admin.vehicles.pictures.index', [
            'vehicle' => $vehicle
        ]);
    }

    public function store(PictureRequest $request, Vehicle $vehicle)
    {
        $request->file->store('truckts/mantenimientos/files', 'public');

        $file = new File([
            'description' => 'Foto',
            'filename' => $request->file->hashName(),
            'content_type' => $request->file->getMimeType()
        ]);
        $file->save();

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
