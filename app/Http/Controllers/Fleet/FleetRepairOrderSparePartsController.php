<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\Helpers;
use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use App\Models\RepairOrderPart;
use App\Models\SparePart;
use Illuminate\Http\Request;

class FleetRepairOrderSparePartsController extends Controller
{
    public function store(Request $request, RepairOrder $repair_order)
    {
        $spare_part = SparePart::where('short_reference', Helpers::shortReference($request->reference))->first();
        if ($spare_part) {
            $spare_part->stock -= (int) $request->quantity;
            $spare_part->save();
        }

        RepairOrderPart::create([
            'repair_order_id' => $repair_order->id,
            'repair_order_operation_id' => $request->operation_id,
            'manufacturer' => $request->manufacturer,
            'reference' => $request->reference,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_price' => $request->unit_price * $request->quantity,
        ]);
    }

    public function update(Request $request, RepairOrder $repair_order, int $part_id)
    {
        $data = $request->except('_token', '_method');
        $part = RepairOrderPart::find($part_id);
        $spare_part = SparePart::where('short_reference', Helpers::shortReference($part->reference))->first();
        $old_quantity = $part->quantity;
        if ($spare_part && $old_quantity != $request->quantity) {  
            $spare_part->stock += $old_quantity - (int) $request->quantity;
            $spare_part->save();
        }

        RepairOrderPart::where('id', $part_id)->update($data);
    }

    public function destroy($repair_order_id, $part_id)
    {
        RepairOrderPart::destroy($part_id);

        return back();
    }
}
