<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use App\Models\RepairOrderState;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRepairOrdersController extends Controller
{

    public function index(Request $request)
    {
        $filters = RepairOrder::filters($request->all());
        $repair_orders = RepairOrder::where($filters)->latest()->get();

        return view('admin.repair_orders.index', [
            'repair_orders' => $repair_orders,
            'states' => RepairOrderState::all()
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
        $order->state_id = RepairOrderState::PENDING_AUTHORIZATION;
        $order->save();

        return redirect()->route('admin.repair-orders.vehicles.create', $order->fresh());
    }

    public function authorization(RepairOrder $repair_order)
    {
        return view('admin.repair_orders.authorization', [
            'repair_order' => $repair_order
        ]);
    }

    public function authorizeRepairOrder(Request $request, RepairOrder $repair_order)
    {
        if ($repair_order->isAuthorized()) {
            return back()->with('error_message', 'La orden ya ha sido autorizada previamente');
        }

        $repair_order->state_id = RepairOrderState::AUTHORIZED;
        $repair_order->remarks = $request->remarks;
        $repair_order->authorized_at = Carbon::now();
        $repair_order->authorizer_user_id = Auth::user()->id;
        $repair_order->save();

        return back()->with('success_message', 'La orden ha sido autorizada y enviada al taller');
    }
}
