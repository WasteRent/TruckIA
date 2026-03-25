<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\PdfGeneratorV2;
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
            'chassis_hours' => $vehicle->chassis_hours,
            'equipment_hours' => $vehicle->equipment_hours,
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
            'chassis_hours' => $request->chassis_hours,
            'equipment_hours' => $request->equipment_hours,
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
            'signature' => $delivery->signature ? $delivery->signature : $request->signature,
            'signature_team' => $delivery->signatureTeam ? $delivery->signatureTeam : $request->signatureTeam,
            'check_front_tire_right' => $request->check_front_tire_right,
            'check_front_tire_left' => $request->check_front_tire_left,
            'check_tire_2_axis_right' => $request->check_tire_2_axis_right,
            'check_tire_2_axis_left' => $request->check_tire_2_axis_left,
            'check_tire_3_axis_right' => $request->check_tire_3_axis_right,
            'check_tire_3_axis_left' => $request->check_tire_3_axis_left,
            'check_front_axle_mud_flaps' => $request->check_front_axle_mud_flaps,
            'check_axle_2_mud_flaps' => $request->check_axle_2_mud_flaps,
            'check_axle_3_mud_flaps' => $request->check_axle_3_mud_flaps,
            'check_fire_extinguishers' => $request->check_fire_extinguishers,
            'check_battery_cap' => $request->check_battery_cap,
            'check_windows_glass' => $request->check_windows_glass,
            'check_fuel_adblue_cap' => $request->check_fuel_adblue_cap,
            'check_rotating_work_lights' => $request->check_rotating_work_lights,
            'check_headlights_pilots_lamps' => $request->check_headlights_pilots_lamps,
            'check_right_mirror' => $request->check_right_mirror,
            'check_left_mirror' => $request->check_left_mirror,
            'check_interior_cleaning' => $request->check_interior_cleaning,
            'check_exterior_cleaning' => $request->check_exterior_cleaning,
            'check_vest_triangle_light' => $request->check_vest_triangle_light,
            'check_documentation' => $request->check_documentation,
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

        if ($request->ajax()) {
            return response()->json(['success' => true]);
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
        ini_set('memory_limit', '-1');
        $html = view('fleet.vehicles.deliveries.pdf', [
            'delivery' => $delivery,
        ])->render();

        $pdf = (new PdfGeneratorV2)->generate($html);

        return response($pdf)->header('Content-Type', 'application/pdf');
    }
}
