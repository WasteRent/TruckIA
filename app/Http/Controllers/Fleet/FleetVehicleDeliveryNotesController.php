<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\PdfGenerator;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Vehicle;
use App\Models\VehicleDeliveryNote;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class FleetVehicleDeliveryNotesController extends Controller
{
    public function create(Vehicle $vehicle)
    {
        $delivery = VehicleDeliveryNote::create([
            'customer_id' => $vehicle->assigned_customer_id,
            'vehicle_id' => $vehicle->id,
            'creator_user_id' => auth()->id(),
            'date' => date('Y-m-d'),
            'kms' => $vehicle->kms,
            'hours' => $vehicle->chassis_can_work_hours
        ]);

        return to_route('fleet.vehicles.deliveries.edit', [$vehicle, $delivery]);
    }

    public function edit(Vehicle $vehicle, VehicleDeliveryNote $delivery)
    {
        return view('fleet.vehicles.deliveries.edit', [
            'vehicle' => $vehicle,
            'delivery' => $delivery,
        ]);
    }

    public function update(Request $request, Vehicle $vehicle, VehicleDeliveryNote $delivery)
    {
        $delivery->update([
            'type' => $request->type,
            'fuel_level' => $request->fuel_level,
            'comments' => $request->comments,
            'kms' => $request->kms,
            'hours' => $request->hours,
            'contract_type' => $request->contract_type,
            'date' => $request->date,
            'check_security' => $request->check_security,
            'check_training' => $request->check_training,
            'check_gps' => $request->check_gps,
            'check_front_tires' => $request->check_front_tires,
            'check_tires_2_axis' => $request->check_tires_2_axis,
            'check_tires_3_axis' => $request->check_tires_3_axis,
            'check_extinguisher' => $request->check_extinguisher,
            'check_clean_cabin' => $request->check_clean_cabin,
            'check_clean_exterior' => $request->check_clean_exterior,
            'check_full_cycle' => $request->check_full_cycle,
            'check_dump_cycle' => $request->check_dump_cycle,
            'check_lights' => $request->check_lights,
            'check_itv' => $request->check_itv,
            'check_tacograph' => $request->check_tacograph,
            'check_preventive_chassis' => $request->check_preventive_chassis,
            'check_preventive_equipment' => $request->check_preventive_equipment,
            'check_security_triangles' => $request->check_security_triangles,
            'check_reflective_vest' => $request->check_reflective_vest,
            'check_documents' => $request->check_documents,
            'check_fluid_levels' => $request->check_fluid_levels,
            'check_rubber_status' => $request->check_rubber_status,
            'signature' => $request->signature,
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

    public function destroy(Vehicle $vehicle, VehicleDeliveryNote $delivery)
    {
        $delivery->delete();

        return back()->with('Albarán eliminado');
    }

    public function pdf(VehicleDeliveryNote $delivery)
    {
        $html = view('fleet.vehicles.deliveries.pdf', [
            'delivery' => $delivery,
        ])->render();

        $pdf = Browsershot::html($html)->paperSize(108, 51)->setChromePath("/usr/bin/chromium-browser")->showBackground()->pdf();

        return response($pdf)->header('Content-Type', 'application/pdf');
    }
}
