<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRepairOrdersController extends Controller
{

    public function index(Request $request)
    {
        $filters = RepairOrder::filters($request->all());
        $repair_orders = RepairOrder::where($filters)->latest()->get();

        return view('admin.repair_orders.index', [
            'repair_orders' => $repair_orders
        ]);
    }

    public function show(int $repair_order_id)
    {
        return view('admin.repair_orders.show', [
            'repair_order' => RepairOrder::findOrFail($repair_order_id)
        ]);
    }

    public function create()
    {
        $order = new RepairOrder();
        $order->creator_user_id = Auth::user()->id;
        $order->save();

        return redirect()->route('admin.repair-orders.vehicles.create', $order->fresh());
    }
}
