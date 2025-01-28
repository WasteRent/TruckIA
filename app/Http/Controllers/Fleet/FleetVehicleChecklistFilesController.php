<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleChecklistFiles;
use Illuminate\Http\Request;

class FleetVehicleChecklistFilesController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'technical_sheet' => 'nullable',
            'vehicle_registration' => 'nullable',
            'equipment_manual' => 'nullable',
            'vehicle_id' => 'required|exists:vehicles,id',
        ]);
    
        $checklistFile = VehicleChecklistFiles::where('vehicle_id', $data['vehicle_id'])->first();
    
        if ($checklistFile) {
            $checklistFile->update([
                'technical_sheet' => $data['technical_sheet'] ?? 0,
                'vehicle_registration' => $data['vehicle_registration'] ?? 0,
                'equipment_manual' => $data['equipment_manual'] ?? 0,
            ]);
        } else {
            $checklistFile = VehicleChecklistFiles::create([
                'technical_sheet' => $data['technical_sheet'] ?? 0,
                'vehicle_registration' => $data['vehicle_registration'] ?? 0,
                'equipment_manual' => $data['equipment_manual'] ?? 0,
                'vehicle_id' => $data['vehicle_id'],
            ]);
            Vehicle::where('id', $data['vehicle_id'])->update(['vehicle_checklist_files_id' => $checklistFile->id]);
        }
    
        return redirect()->back();
    
        
    }
}
