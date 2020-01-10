<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use Illuminate\Http\Request;

class AdminCreateRepairOrderController extends Controller
{
    public function step1()
    {
        return view('admin.repair_orders.create.step1-vehicle');
    }
}
