<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use App\Models\RepairOrderPart;
use Illuminate\Http\Request;

class GarageRepairOrderSparePartsController extends Controller
{
    public function store(Request $request, RepairOrder $repair_order)
    {
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
        $data = $request->toArray();
        $data['total_price'] = $request->unit_price * $request->quantity;
        RepairOrderPart::where('id', $part_id)->update($data);
    }

    public function destroy($repair_order_id, $part_id)
    {
        RepairOrderPart::destroy($part_id);

        return back();
    }
}
