<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\VehicleDeliveryNote;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FleetVehicleDeliveryFileController extends Controller
{
    public function store(Request $request, VehicleDeliveryNote $delivery)
    {
        $request->validate(['file' => 'required|file']);

        $file = File::storeFile($request->file, 'Delivery extra image');

        $delivery->files()->attach($file);

        return back()->with('success_message', 'Archivo añadido');
    }
}
