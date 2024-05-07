<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use Illuminate\Http\Request;

class FleetRepairOrderCustomOperationController extends Controller
{
    public function store(Request $request, RepairOrder $repair_order)
    {
        $request->validate([
            'name' => 'required',
            'real_time' => 'nullable|numeric',
            'amount' => 'nullable|numeric',
            'operation_code' => 'nullable',
        ]);

        $repair_order->operations()->save(new RepairOrderOperation([
            'operation_name' => $request->name,
            'operation_description' => $request->description,
            'estimated_time_in_hours' => $request->estimated_time,
            'real_time_in_hours' => $request->real_time,
            'amount' => $request->amount,
            'operation_code' => $request->operation_code,
        ]));
    }

    public function update(Request $request, RepairOrder $repair_order, RepairOrderOperation $operation)
    {
        $operation->update($request->toArray());
    }
}
