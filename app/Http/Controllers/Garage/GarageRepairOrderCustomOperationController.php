<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use Illuminate\Http\Request;

class GarageRepairOrderCustomOperationController extends Controller
{

    public function store(Request $request, RepairOrder $repair_order)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'time' => 'required|numeric|gt:0'
        ]);

        $repair_order->operations()->save(new RepairOrderOperation([
           'operation_name' => $request->name,
           'operation_description' => $request->description,
           'estimated_time_in_hours' => $request->time,
        ]));
    }
}
