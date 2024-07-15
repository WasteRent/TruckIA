<?php

namespace App\Http\Controllers\Customer;

use App\Models\Vehicle;
use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Models\VehicleChecklist;
use Spatie\Browsershot\Browsershot;
use App\Http\Controllers\Controller;
use App\Models\VehicleChecklistItem;

class CustomerVehicleChecklistController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        return view('customer.vehicles.checklist.index', [
            'vehicle' => $vehicle,
            'checklists' => Checklist::all(),
        ]);
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $checklist = Checklist::find($request->checklist_id);
        $vehicle_checklist = VehicleChecklist::create([
            'vehicle_id' => $vehicle->id,
            'checklist_id' => $checklist->id,
        ]);

        foreach ($checklist->items as $item) {
            VehicleChecklistItem::create([
                'vehicle_checklist_id' => $vehicle_checklist->id,
                'checklist_item_id' => $item->id,
            ]);
        }

        $redirectUrl = route('customer.vehicle-checklists.edit', $vehicle_checklist);
        return response()->json(['redirectUrl' => $redirectUrl])
            ->header('X-Redirect-Url', $redirectUrl);
    }

    public function generatePdf(VehicleChecklist $vehicle_checklist)
    {
        ini_set('memory_limit', '-1');

        $html = view('customer.vehicles.checklist.pdf', [
            'vehicle_checklist' => $vehicle_checklist,
        ])->render();
        $pdf = Browsershot::html($html)->setChromePath('/usr/bin/chromium-browser')->showBackground()->pdf();

        return response($pdf)->header('Content-Type', 'application/pdf');
    }
}
