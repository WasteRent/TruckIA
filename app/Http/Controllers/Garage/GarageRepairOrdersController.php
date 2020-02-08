<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GarageRepairOrdersController extends Controller
{
    public function index()
    {
        return view('garage.repair_orders.index', [
            'repair_orders' => Auth::user()->garage->repairOrders
        ]);
    }
}
