<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleChecklistFile;
use Illuminate\Http\Request;

class FleetVehicleChecklistFilesController extends Controller
{
    public function store(Request $request)
{

    $data = $request->validate([
        'vehicle_checklist_files' => 'array',
        'vehicle_id' => 'required',
    ]);


    foreach ($data["vehicle_checklist_files"] as $fileTypeId => $checked) {
        $existChecklistFile = VehicleChecklistFile::where([
            'vehicle_id' => $data['vehicle_id'],
            'vehicle_checklist_file_type_id' => $fileTypeId,
        ])->first();

        if (!$existChecklistFile) {
            $existChecklistFile = VehicleChecklistFile::create([
                'vehicle_id' => $data['vehicle_id'],
                'vehicle_checklist_file_type_id' => $fileTypeId,
                'is_checked' => ($checked == VehicleChecklistFile::ISCHECKED) 
                    ? VehicleChecklistFile::ISCHECKED 
                    : VehicleChecklistFile::ISNOTCHECKED
            ]);
        } else {
            $existChecklistFile->update([
                'is_checked' => ($checked == VehicleChecklistFile::ISCHECKED) 
                    ? VehicleChecklistFile::ISCHECKED 
                    : VehicleChecklistFile::ISNOTCHECKED
            ]);
        }
    }

    return redirect()->back();
}
}
