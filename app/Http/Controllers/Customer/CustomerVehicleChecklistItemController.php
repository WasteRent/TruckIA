<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\VehicleChecklist;
use Illuminate\Http\Request;

class CustomerVehicleChecklistItemController extends Controller
{
    public function edit(VehicleChecklist $vehicle_checklist)
    {
        return view('customer.vehicles.checklist.edit', [
            'vehicle_checklist' => $vehicle_checklist,
            'vehicle' => $vehicle_checklist->vehicle,
            'grid_x' => 24,
            'grid_y' => 14,
        ]);
    }

    public function update(Request $request, VehicleChecklist $vehicle_checklist)
    {
        foreach ($request->items ?? [] as $item_id => $result) {
            $item = $vehicle_checklist->items->where('id', $item_id)->first();
            $item->result = $result;
            $item->save();
        }

        $vehicle_checklist->update([
            'notes' => $request->notes,
            'engine_hours' => $request->engine_hours,
            'tdf_hours' => $request->tdf_hours,
            'date' => $request->date,
            'signature' => $request->signature,
            'grid' => $request['grid'],
            'positions' => json_decode($request['grid-position']),
        ]);

        return back()->with('Checklist actualizada');
    }

    public function destroy(VehicleChecklist $vehicle_checklist)
    {
        $vehicle_checklist->items()->delete();
        $vehicle_checklist->delete();

        return back()->with('success_message', 'Checklist eliminada');
    }
}
