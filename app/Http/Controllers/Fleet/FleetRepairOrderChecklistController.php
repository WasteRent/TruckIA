<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\PdfGeneratorV2;
use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\RepairOrder;
use App\Models\RepairOrderChecklist;
use App\Models\RepairOrderChecklistItem;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class FleetRepairOrderChecklistController extends Controller
{
    public function index(RepairOrder $repair_order)
    {
        return view('fleet.repair_orders.checklist.index', [
            'repair_order' => $repair_order,
            'checklists' => Checklist::excludingType(Checklist::TYPE_CONTAINER)->get(),
        ]);
    }


    public function store(Request $request, RepairOrder $repair_order)
    {
        $checklist = Checklist::find($request->checklist_id);
        $repair_order_checklist = RepairOrderChecklist::create([
            'repair_order_id' => $repair_order->id,
            'checklist_id' => $checklist->id,
        ]);

        foreach ($checklist->items as $item) {
            RepairOrderChecklistItem::create([
                'repair_order_checklist_id' => $repair_order_checklist->id,
                'checklist_item_id' => $item->id,
            ]);
        }

        $redirectUrl = route('fleet.repair-order-checklists.edit', $repair_order_checklist);
        return response()->json(['redirectUrl' => $redirectUrl])
            ->header('X-Redirect-Url', $redirectUrl);
    }

    public function generatePdf(RepairOrderChecklist $repair_order_checklist)
    {
        ini_set('memory_limit', '-1');

        $html = view('fleet.repair_orders.checklist.pdf', [
            'repair_order_checklist' => $repair_order_checklist,
        ])->render();

        $pdf = (new PdfGeneratorV2)->generate($html);

        return response($pdf)->header('Content-Type', 'application/pdf');
    }
}
