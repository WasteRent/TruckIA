<?php

namespace App\Http\Controllers\Fleet;

use App\Models\Vehicle;
use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Models\VehicleChecklist;
use Spatie\Browsershot\Browsershot;
use App\Http\Controllers\Controller;
use App\Models\VehicleChecklistItem;

class FleetVehicleChecklistController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.checklist.index', [
            'vehicle' => $vehicle,
            'checklists' => Checklist::all(),
        ]);
    }

    public function generatePdf(VehicleChecklist $vehicle_checklist)
    {
        ini_set('memory_limit', '-1');

        $html = view('customer.vehicles.checklist.pdf', [
            'vehicle_checklist' => $vehicle_checklist,
        ]);
        $pdf = Browsershot::html($html)->setChromePath('/usr/bin/chromium-browser')->showBackground()->pdf();

        return response($pdf)->header('Content-Type', 'application/pdf');
    }
}
