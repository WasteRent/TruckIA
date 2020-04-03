<?php

namespace App\Http\Controllers\Admin;

use App\Classes\AlertService;
use App\Classes\RapairOrderStateService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RepairOrderRequest;
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

    public function show(RepairOrder $repairOrder)
    {
        return view('admin.repair_orders.show', [
            'repair_order' => $repairOrder
        ]);
    }

    public function create()
    {
        return view('admin.repair_orders.create');
    }

    public function store(RepairOrderRequest $request)
    {
        $order = new RepairOrder();
        $order->state_id = RepairOrderState::PENDING_AUTHORIZATION;
        $order->type = $request->type;
        $order->vehicle_id = $request->vehicle_id;
        $order->garage_id = $request->garage_id;
        $order->creator_user_id = Auth::user()->id;
        $order->save();

        RapairOrderStateService::transit($order->id, RepairOrderState::PENDING_AUTHORIZATION);

        $request->session()->forget('garage');
        $request->session()->forget('vehicle');

        return redirect()->route('admin.repair-orders.operations.index', $order);
    }

    public function vehicle(RepairOrder $repairOrder)
    {
        return view('admin.repair_orders.vehicle', [
            'repair_order' => $repairOrder
        ]);
    }

    public function garage(RepairOrder $repairOrder)
    {
        return view('admin.repair_orders.garage', [
            'repair_order' => $repairOrder
        ]);
    }

    public function cancel(RepairOrder $repairOrder)
    {
        RapairOrderStateService::transit($repairOrder->id, RepairOrderState::CANCELED);
        return back()->with('success_message', 'OR cancelada');
    }


    public function authorization(RepairOrder $repairOrder)
    {
        return view('admin.repair_orders.authorization', [
            'repair_order' => $repairOrder
        ]);
    }

    public function authorizeRepairOrder(Request $request, RepairOrder $repair_order)
    {
        if ($repair_order->isAuthorized()) {
            return back()->with('error_message', 'La orden ya ha sido autorizada previamente');
        }

        $repair_order->remarks = $request->remarks;
        $repair_order->authorized_at = Carbon::now();
        $repair_order->authorizer_user_id = Auth::user()->id;
        $repair_order->save();

        RapairOrderStateService::transit($repair_order->id, RepairOrderState::AUTHORIZED);

        $repair_order->garage->notify(
            $repair_order->vehicle_id,
            "Solicitud de mantenimiento #{$repair_order->id}",
            "Tienes disponible un nuevo mantenimiento para el vehículo"
        );
        $repair_order->vehicle->fleet->notify(
            $repair_order->vehicle_id,
            "Mantenimiento concertado",
            "El vehículo tiene mantenmiento con el taller {$repair_order->garage->name}"
        );
        $repair_order->vehicle->customers->each->notify(
            $repair_order->vehicle_id,
            "Mantenimiento de vehículo concertado",
            "El vehículo tiene mantenmiento con el taller {$repair_order->garage->name}"
        );

        return redirect()
                ->route('admin.repair-orders.show', $repair_order)
                ->with('success_message', 'La orden ha sido autorizada y enviada al taller');
    }
}
