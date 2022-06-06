<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\File;
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
            'vehicle_id' => $vehicle->id,
            'creator_user_id' => auth()->id(),
            'date' => date('Y-m-d')
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

    public function update(Request $request, Vehicle $vehicle, VehicleDeliveryNote $delivery)
    {
        $delivery->update([
            'type' => $request->type,
            'fuel_level' => $request->fuel_level,
            'comments' => $request->comments,
            'date' => $request->date,
            'check_front_tires' => $request->boolean('check_front_tires'),
            'check_tires_2_axis' => $request->boolean('check_tires_2_axis'),
            'check_tires_3_axis' => $request->boolean('check_tires_3_axis'),
            'check_extinguisher' => $request->boolean('check_extinguisher'),
            'check_clean_cabin' => $request->boolean('check_clean_cabin'),
            'check_clean_exterior' => $request->boolean('check_clean_exterior'),
        ]);

        if ($request->front_picture_id) {
            $file = File::storeFile($request->front_picture_id, 'albarán delantera');
            $delivery->update(['front_picture_id' => $file->id]);
        }
        if ($request->back_picture_id) {
            $file = File::storeFile($request->back_picture_id, 'albarán trasera');
            $delivery->update(['back_picture_id' => $file->id]);
        }
        if ($request->left_picture_id) {
            $file = File::storeFile($request->left_picture_id, 'albarán izquierda');
            $delivery->update(['left_picture_id' => $file->id]);
        }
        if ($request->right_picture_id) {
            $file = File::storeFile($request->right_picture_id, 'albarán derecha');
            $delivery->update(['right_picture_id' => $file->id]);
        }

        return back()->with('Albarán actualizado');
    }

    public function destroy(Vehicle $vehicle, VehicleDeliveryNote $delivery) {
        $delivery->delete();
        return back()->with('Albarán eliminado');
    }
}
