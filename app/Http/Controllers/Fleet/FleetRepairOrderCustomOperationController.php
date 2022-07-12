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
            'description' => 'required',
            'real_time' => 'required|numeric|gt:0',
            'amount' => 'required|numeric|gt:0',
        ]);

        $repair_order->operations()->save(new RepairOrderOperation([
            'operation_name' => $request->name,
            'operation_description' => $request->description,
            'estimated_time_in_hours' => $request->estimated_time,
            'real_time_in_hours' => $request->real_time,
            'amount' => $request->amount,
        ]));
    }

    public function update(Request $request, RepairOrder $repair_order, RepairOrderOperation $operation)
    {
        $operation->update($request->toArray());
    }
}
