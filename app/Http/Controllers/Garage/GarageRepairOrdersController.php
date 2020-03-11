<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use App\Models\RepairOrderState;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GarageRepairOrdersController extends Controller
{
    public function index(Request $request)
    {
        $filters = RepairOrder::filters($request->all());

        $orders = Auth::user()->garage->repairOrders()
        ->where($filters)
        ->whereIn('state_id', [
            RepairOrderState::PENDING_AUTHORIZATION,
            RepairOrderState::AUTHORIZED,
            RepairOrderState::REPAIRING,
            RepairOrderState::FINISHED
        ])
        ->latest()
        ->get();

        return view('garage.repair_orders.index', [
            'repair_orders' => $orders,
            'states' => RepairOrderState::all()
        ]);
    }

    public function create()
    {
        $order = new RepairOrder();
        $order->garage_id = Auth::user()->garage->id;
        $order->creator_user_id = Auth::user()->id;
        $order->state_id = RepairOrderState::PENDING_AUTHORIZATION;
        $order->save();

        return redirect()->route('garage.repair-orders.vehicles.create', $order->fresh());
    }

    public function show(RepairOrder $repair_order)
    {
        return view('garage.repair_orders.show', [
            'repair_order' => $repair_order
        ]);
    }

    public function authorization(RepairOrder $repair_order)
    {
        return view('garage.repair_orders.authorization', [
            'repair_order' => $repair_order
        ]);
    }

    public function authorizeRepairOrder(Request $request, RepairOrder $repair_order)
    {
        if ($repair_order->isAuthorized()) {
            return back()->with('error_message', 'La orden ya ha sido autorizada previamente');
        }

        if ($repair_order->getEstimatedAmount() > 500) {
            return back()->with('success_message', 'Autorización pendiente');
        } else {
            $repair_order->state_id = RepairOrderState::AUTHORIZED;
            $repair_order->authorized_at = Carbon::now();
            $repair_order->authorizer_user_id = Auth::user()->id;
            $repair_order->save();
            return back()->with('success_message', 'Reparación autorizada');
        }
    }
}
