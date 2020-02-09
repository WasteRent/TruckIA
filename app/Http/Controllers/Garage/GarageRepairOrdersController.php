<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use Illuminate\Support\Facades\Auth;

class GarageRepairOrdersController extends Controller
{
    public function index()
    {
        return view('garage.repair_orders.index', [
            'repair_orders' => Auth::user()->garage->repairOrders()->authorized()->get()
        ]);
    }

    public function show(RepairOrder $repair_order)
    {
        return view('garage.repair_orders.show', [
            'repair_order' => $repair_order
        ]);
    }
}
