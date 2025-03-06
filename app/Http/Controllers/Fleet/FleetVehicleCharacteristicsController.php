<?php

namespace App\Http\Controllers\Fleet;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FleetVehicleCharacteristicsController extends Controller
{
    public function update(Request $request, Vehicle $vehicle)
    {
        $vehicle->characteristics = $request->characteristics;
        $vehicle->save();
        return redirect()->back()->with('success_message', 'Características del vehículo actualizadas correctamente');
    }
}
