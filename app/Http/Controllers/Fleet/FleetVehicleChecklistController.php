<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\PdfGeneratorV2;
use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\Vehicle;
use App\Models\VehicleChecklist;
use App\Models\VehicleChecklistItem;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class FleetVehicleChecklistController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.checklist.index', [
            'vehicle' => $vehicle,
            'checklists' => Checklist::excludingType(Checklist::TYPE_CONTAINER)->get(),
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

        $redirectUrl = route('fleet.vehicle-checklists.edit', $vehicle_checklist);
        return response()->json(['redirectUrl' => $redirectUrl])
            ->header('X-Redirect-Url', $redirectUrl);
    }

    public function generatePdf(VehicleChecklist $vehicle_checklist)
    {
        ini_set('memory_limit', '-1');

        $html = view('fleet.vehicles.checklist.pdf', [
            'vehicle_checklist' => $vehicle_checklist,
        ])->render();

        $pdf = (new PdfGeneratorV2)->generate($html);

        return response($pdf)->header('Content-Type', 'application/pdf');
    }
}
