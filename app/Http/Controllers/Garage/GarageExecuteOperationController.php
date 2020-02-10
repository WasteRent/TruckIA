<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use App\Models\RepairOrder;

class GarageExecuteOperationController extends Controller
{
    public function show(RepairOrder $repair_order, Operation $operation)
    {
        return view('garage.repair_orders.execute', [
            'repair_order' => $repair_order,
            'current_operation' => $operation
        ]);
    }

    public function store()
    {
    }
}
