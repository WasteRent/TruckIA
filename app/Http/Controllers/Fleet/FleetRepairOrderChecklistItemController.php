<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\RepairOrderChecklist;
use Illuminate\Http\Request;

class FleetRepairOrderChecklistItemController extends Controller
{
    public function edit(RepairOrderChecklist $repair_order_checklist)
    {
        return view('fleet.repair_orders.checklist.edit', [
            'repair_order_checklist' => $repair_order_checklist,
            'repair_order' => $repair_order_checklist->repairOrder,
            'grid_x' => 24,
            'grid_y' => 14,
        ]);
    }

    public function update(Request $request, RepairOrderChecklist $repair_order_checklist)
    {
        foreach ($request->items ?? [] as $item_id => $result) {
            $item = $repair_order_checklist->items->where('id', $item_id)->first();
            $item->result = $result;
            $item->save();
        }

        $repair_order_checklist->update([
            'notes' => $request->notes,
            'signature' => $request->signature,
            'grid' => $request['grid'],
            'positions' => json_decode($request['grid-position']),
        ]);

        return back()->with('Checklist actualizada');
    }

    public function destroy(RepairOrderChecklist $repair_order_checklist)
    {
        $repair_order_checklist->items()->delete();
        $repair_order_checklist->delete();

        return back()->with('success_message', 'Checklist eliminada');
    }
}
