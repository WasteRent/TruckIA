<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleDeliveryNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetVehicleDeliveryNotesController extends Controller
{
    public function create(Vehicle $vehicle)
    {
        $delivery = VehicleDeliveryNote::create([
            'customer_id' => $vehicle->assigned_customer_id, 
            'vehicle_id' => $vehicle->id
        ]);

        return to_route('fleet.vehicles.deliveries.edit', [$vehicle, $delivery]);
    }

    public function edit(Vehicle $vehicle, VehicleDeliveryNote $delivery)
    {
        return view('fleet.vehicles.deliveries.edit', [
            'vehicle' => $vehicle,
            'delivery' => $delivery
        ]);
    }
}
