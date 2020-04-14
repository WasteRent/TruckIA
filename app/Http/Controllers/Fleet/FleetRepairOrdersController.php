<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\AlertService;
use App\Classes\RapairOrderStateService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\RepairOrderRequest;
use App\Models\AlertType;
use App\Models\RepairOrder;
use App\Models\RepairOrderState;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FleetRepairOrdersController extends Controller
{

    public function index(Request $request)
    {
        $filters = RepairOrder::filters($request->all());
        $repair_orders = RepairOrder::where($filters)->latest()->get();

        return view('fleet.repair_orders.index', [
            'repair_orders' => $repair_orders,
            'states' => RepairOrderState::all()
        ]);
    }

    public function show(RepairOrder $repairOrder)
    {
        return view('fleet.repair_orders.show', [
            'repair_order' => $repairOrder
        ]);
    }

    public function create(Request $request)
    {
        if ($request->query('vehicle_id')) {
            session(['vehicle' => Vehicle::findOrFail($request->query('vehicle_id'))]);
        }

        return view('fleet.repair_orders.create');
    }

    public function store(RepairOrderRequest $request)
    {
        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        $order = new RepairOrder();
        $order->state_id = RepairOrderState::PENDING_AUTHORIZATION;
        $order->type = $request->type;
        $order->vehicle_id = $request->vehicle_id;
        $order->garage_id = $request->garage_id;
        $order->creator_user_id = Auth::user()->id;
        $order->kms = $vehicle->kms;
        $order->work_hours = $vehicle->can_hours ?? $vehicle->work_hours;
        $order->save();

        RapairOrderStateService::transit($order->id, RepairOrderState::PENDING_AUTHORIZATION);

        $request->session()->forget('garage');
        $request->session()->forget('vehicle');

        return redirect()->route('fleet.repair-orders.operations.index', $order);
    }

    public function vehicle(RepairOrder $repairOrder)
    {
        return view('fleet.repair_orders.vehicle', [
            'repair_order' => $repairOrder
        ]);
    }

    public function garage(RepairOrder $repairOrder)
    {
        return view('fleet.repair_orders.garage', [
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
        return view('fleet.repair_orders.authorization', [
            'repair_order' => $repairOrder
        ]);
    }

    public function authorizeRepairOrder(Request $request, RepairOrder $repair_order)
    {
        if ($repair_order->isAuthorized()) {
            return back()->with('error_message', 'La orden ya ha sido autorizada previamente');
        } else if ($repair_order->operations()->count() == 0) {
            return back()->with('error_message', 'La orden no tiene ninguna operación');
        }

        try {
            DB::beginTransaction();

            $repair_order->update([
                'remarks' => $request->remarks,
                'authorized_at' => Carbon::now(),
                'authorizer_user_id' => Auth::user()->id
            ]);

            RapairOrderStateService::transit($repair_order->id, RepairOrderState::AUTHORIZED);

            $this->generateAlerts($repair_order);
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        
        return redirect()
                ->route('fleet.repair-orders.show', $repair_order)
                ->with('success_message', 'La orden ha sido autorizada y enviada al taller');
    }

    private function generateAlerts($repair_order)
    {
        $repair_order->garage->sendAlert(
            $repair_order->vehicle_id,
            "Solicitud de mantenimiento #{$repair_order->id}",
            "Tienes disponible un nuevo mantenimiento para el vehículo",
            AlertType::MAINTENANCE
        );
        if ($repair_order->vehicle->customer) {
            $repair_order->vehicle->customer->sendAlert(
                $repair_order->vehicle_id,
                "Mantenimiento de vehículo concertado",
                "El vehículo tiene mantenimiento con el taller {$repair_order->garage->name}",
                AlertType::MAINTENANCE
            );
        }
    }
}
