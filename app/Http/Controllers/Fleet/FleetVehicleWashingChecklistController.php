<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\VehicleWashingChecklist;
use Illuminate\Http\Request;

class FleetVehicleWashingChecklistController extends Controller
{
    public function store(Request $request)
    {

        $data = $request->validate([
            'vehicle_washing_types' => 'array',
            'vehicle_washing_id' => 'required',
        ]);


        foreach ($data["vehicle_washing_types"] as $typeId => $checked) {
            $existChecklistItem = VehicleWashingChecklist::where([
                'vehicle_washing_id' => $data['vehicle_washing_id'],
                'vehicle_washing_type_id' => $typeId,
            ])->first();

            if (!$existChecklistItem) {
                $existChecklistItem = VehicleWashingChecklist::create([
                    'vehicle_washing_id' => $data['vehicle_washing_id'],
                    'vehicle_washing_type_id' => $typeId,
                    'is_checked' => ($checked == VehicleWashingChecklist::ISCHECKED)
                        ? VehicleWashingChecklist::ISCHECKED
                        : VehicleWashingChecklist::ISNOTCHECKED
                ]);
            } else {
                $existChecklistItem->update([
                    'is_checked' => ($checked == VehicleWashingChecklist::ISCHECKED)
                        ? VehicleWashingChecklist::ISCHECKED
                        : VehicleWashingChecklist::ISNOTCHECKED
                ]);
            }
        }

        return redirect()->back();
    }
}
