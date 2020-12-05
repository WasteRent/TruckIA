<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;

class GarageRepairOrderInvoiceController extends Controller
{

    public function index(RepairOrder $repair_order)
    {
        return view('fleet.repair_orders.invoice', [
          'repair_order' => $repair_order
        ]);
    }
}
