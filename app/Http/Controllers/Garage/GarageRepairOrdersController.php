<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\RepairOrderRequest;
use App\Models\RepairOrder;
use App\Models\RepairOrderState;
use App\User;
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
        return view('garage.repair_orders.create');
    }

    public function store(RepairOrderRequest $request)
    {
        $order = new RepairOrder();
        $order->vehicle_id = $request->vehicle_id;
        $order->garage_id = Auth::user()->garage->id;
        $order->creator_user_id = Auth::user()->id;
        $order->state_id = RepairOrderState::PENDING_AUTHORIZATION;
        $order->save();

        $request->session()->forget('vehicle');

        return redirect()->route('garage.repair-orders.operations.index', $order);
    }

    public function vehicle(RepairOrder $repairOrder)
    {
        return view('garage.repair_orders.vehicle', [
            'repair_order' => $repairOrder
        ]);
    }

    public function show(RepairOrder $repair_order)
    {
        $repair_order->updateSeenTimestamps();

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
            $repair_order->vehicle->fleet->notify(
                $repair_order->vehicle->id,
                'Solicitud de autorización',
                "El taller {$repair_order->garage->name} require que se autorice la orden #{$repair_order->id}"
            );
            User::where('role', 'admin')->get()->each->notify(
                $repair_order->vehicle->id,
                'Solicitud de autorización',
                "El taller {$repair_order->garage->name} require que se autorice la orden #{$repair_order->id}"
            );

            return back()->with('warning_message', 'Autorización pendiente');
        } else {
            $repair_order->state_id = RepairOrderState::AUTHORIZED;
            $repair_order->authorized_at = Carbon::now();
            $repair_order->authorizer_user_id = Auth::user()->id;
            $repair_order->save();
            return redirect()
                    ->route('garage.repair-orders.show', $repair_order)
                    ->with('success_message', 'Reparación autorizada');
        }
    }
}
