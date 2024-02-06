<?php

namespace App\Http\Controllers\Garage;

use App\Classes\AlertService;
use App\Classes\RapairOrderStateService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\RepairOrderRequest;
use App\Models\AlertType;
use App\Models\File;
use App\Models\RepairOrder;
use App\Models\RepairOrderState;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GarageRepairOrdersController extends Controller
{
    public function index(Request $request)
    {
        $filters = RepairOrder::filters($request->all());

        $orders = Auth::user()->garage->repairOrders()
        ->whereNotIn('state_id', [RepairOrderState::CANCELED,  RepairOrderState::FINISHED])
        ->where($filters)
        ->where('fleet_id', Auth::user()->garage->fleet->id)
        ->latest()
        ->get();

        return view('garage.repair_orders.index', [
            'repair_orders' => $orders,
            'states' => RepairOrderState::all(),
        ]);
    }

    public function create(Request $request)
    {
        if ($request->query('vehicle_id')) {
            session(['vehicle' => Vehicle::findOrFail($request->query('vehicle_id'))]);
        }

        return view('garage.repair_orders.create');
    }

    public function store(RepairOrderRequest $request)
    {
        $order = new RepairOrder();
        $order->vehicle_id = $request->vehicle_id;
        $order->fleet_id = Auth::user()->garage->fleet->id;
        $order->garage_id = Auth::user()->garage->id;
        $order->garage_hourly_fare = Auth::user()->garage->hourly_price;
        $order->creator_user_id = Auth::user()->id;
        $order->state_id = RepairOrderState::PENDING_AUTHORIZATION;
        $order->type = 'corrective';
        $order->save();

        RapairOrderStateService::transit($order->id, RepairOrderState::PENDING_AUTHORIZATION);

        $request->session()->forget('vehicle');

        return redirect()->route('garage.repair-orders.operations.index', $order);
    }

    public function updateState(Request $request, RepairOrder $repairOrder)
    {
        if ($request->state_id) {
            RapairOrderStateService::transit($repairOrder->id, $request->state_id);

            return back()->with('success_message', 'Estado actualizado');
        }
    }

    public function updateItv(Request $request, RepairOrder $repairOrder)
    {
        if ($request->scheduled_itv_date) {
            $repairOrder->update(['scheduled_itv_date' => $request->scheduled_itv_date]);
            RapairOrderStateService::transit($repairOrder->id, RepairOrderState::ITV_APPOINTMENT_ARRANGED);

            return back()->with('success_message', 'Fecha ITV actualizada');
        }
        if ($request->itv_correct_file) {
            $file = File::storeFile($request->itv_correct_file, 'ITV');
            $repairOrder->update(['itv_file_id' => $file->id, 'itv_correct' => 1]);
            RapairOrderStateService::transit($repairOrder->id, RepairOrderState::ITV_CORRECT);

            return back()->with('success_message', 'ITV actualizada');
        }
        if ($request->itv_failed_file) {
            $file = File::storeFile($request->itv_failed_file, 'ITV');
            $repairOrder->update(['itv_file_id' => $file->id, 'itv_correct' => 0]);
            RapairOrderStateService::transit($repairOrder->id, RepairOrderState::ITV_FAILED);

            return back()->with('success_message', 'ITV actualizada');
        }

        return back();
    }

    public function vehicle(RepairOrder $repairOrder)
    {
        return view('garage.repair_orders.vehicle', [
            'repair_order' => $repairOrder,
        ]);
    }

    public function show(RepairOrder $repair_order)
    {
        $repair_order->updateSeenTimestamps();

        return view('garage.repair_orders.show', [
            'repair_order' => $repair_order,
        ]);
    }

    public function authorization(RepairOrder $repair_order)
    {
        return view('garage.repair_orders.authorization', [
            'repair_order' => $repair_order,
        ]);
    }

    public function authorizeRepairOrder(Request $request, RepairOrder $repair_order)
    {
        if ($repair_order->isAuthorized()) {
            return back()->with('error_message', 'La orden ya ha sido autorizada previamente');
        }

        $amount_estimation = $repair_order->operations->sum('estimated_time_in_hours') * $repair_order->garage->hourly_price;

        if ($amount_estimation > 500) {
            (new AlertService)->to($repair_order->vehicle->fleet)->forVehicle($repair_order->vehicle)->notify(
                'Solicitud de autorización',
                "Taller {$repair_order->garage->name} require que se autorice la orden #{$repair_order->id}",
                "/fleet/repair-orders/{$repair_order->id}/authorization",
                AlertType::MAINTENANCE
            );

            return back()->with('warning_message', 'Autorización pendiente');
        } else {
            $repair_order->authorized_at = Carbon::now();
            $repair_order->authorizer_user_id = Auth::user()->id;
            $repair_order->save();

            RapairOrderStateService::transit($repair_order->id, RepairOrderState::AUTHORIZED);

            return redirect()
                    ->route('garage.repair-orders.show', $repair_order)
                    ->with('success_message', 'Reparación autorizada');
        }
    }

    public function pdf(Request $request, RepairOrder $repair_order)
    {
        $operations = $repair_order->operations;

        if ($request->plan_id) {
            $operations = $operations->where('maintenance_plan_id', $request->plan_id);
        }

        $html = view('garage.repair_orders.operations.pdf', [
            'repair_order' => $repair_order,
            'operations' => $operations,
        ]);

        return $html;
    }

    public function dashboard(Request $request)
    {
        $filters = RepairOrder::filters($request->all());

        $orders = Auth::user()->garage->repairOrders()
        ->where($filters)
        ->where('fleet_id', Auth::user()->garage->fleet->id)
        ->whereNotIn('state_id', [RepairOrderState::CANCELED,  RepairOrderState::FINISHED])
        ->latest()
        ->get();

        return view('garage.dashboard', [
            'repair_orders' => $orders,
            'states' => RepairOrderState::all(),
        ]);
    }
}
