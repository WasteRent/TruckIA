<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleNote;
use Illuminate\Http\Request;

class FleetVehicleStateController extends Controller
{
    public function update(Request $request, Vehicle $vehicle)
    {
        $vehicle->changeState($request->state_id, $request->date . ' ' . date('H:i:s'));
        
        VehicleNote::create([
            'user_id' => auth()->user()->id,
            'note' => $request->notes,
            'vehicle_id' => $vehicle->id,
            'created_at' => $request->date . ' ' . date('H:i:s')
        ]);

        return back()->with('success_message', 'Vehículo en taller');
    }
}
