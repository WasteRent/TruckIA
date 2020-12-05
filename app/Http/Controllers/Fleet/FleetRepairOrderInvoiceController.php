<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;

class FleetRepairOrderInvoiceController extends Controller
{

    public function index(RepairOrder $repair_order)
    {
        return view('fleet.repair_orders.invoice', [
          'repair_order' => $repair_order
        ]);
    }
}
