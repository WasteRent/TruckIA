<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\AlertService;
use App\Classes\RapairOrderStateService;
use App\Classes\RepairOrderReferenceGenerator;
use App\Events\MechanicAssignedToOrder;
use App\Events\RepairOrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\RepairOrderRequest;
use App\Http\Requests\Fleet\UpdateRepairOrderRequest;
use App\Models\AlertType;
use App\Models\Garage;
use App\Models\MaintenancePlan;
use App\Models\OperationFamily;
use App\Models\RepairOrder;
use App\Models\RepairOrderState;
use App\Models\UniversalOperation;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FleetRepairOrdersController extends Controller
{
    public function index(Request $request)
    {
        $repair_orders = RepairOrder::filter($request->toArray())
                ->where('fleet_id', Auth::user()->fleet->id)
                ->whereHas('vehicle', function ($q) {
                    $q->allowForUser();
                })
                ->latest()
                ->paginate(20);

        return view('fleet.repair_orders.index', [
            'repair_orders' => $repair_orders,
            'states' => RepairOrderState::all(),
        ]);
    }

    public function storeSimplified(Request $request, RepairOrder $repair_order)
    {
        $this->authorize('view', $repair_order);

        $operations_search = [];
        if ($request->name & $request->family_id) {
            $operations_search = UniversalOperation::where('name', 'LIKE', "%{$request->name}%")->where('family_id', $request->family_id)->get();
        } else {
            if ($request->name) {
                $operations_search = UniversalOperation::where('name', 'LIKE', "%{$request->name}%")->get();
            }
            if ($request->family_id) {
                $operations_search = UniversalOperation::where('family_id', $request->family_id)->get();
            }
        }

        $plans = Vehicle::findOrFail($repair_order->vehicle_id)->getMaintenancePlans();
        $common_plans = MaintenancePlan::whereNull('manufacturer_id')->whereNull('model_id')->get();

        return view('fleet.repair_orders.store-simplified', [
            'repair_order' => $repair_order,
            'states' => RepairOrderState::all(),
            'plans' => $plans->merge($common_plans),
            'operations' => $repair_order->operations,
            'operations_search' => $operations_search,
            'families' => OperationFamily::all(),
        ]);
    }

    public function show(RepairOrder $repairOrder)
    {
        $this->authorize('view', $repairOrder);

        return view('fleet.repair_orders.show', [
            'repair_order' => $repairOrder,
            'states' => RepairOrderState::all(),
        ]);
    }

    public function create(Request $request)
    {
        if ($request->query('vehicle_id')) {
            session(['vehicle' => Vehicle::findOrFail($request->query('vehicle_id'))]);
        }

        if (Str::of(app('url')->previous())->contains('fleet/repair-orders?state_id')) {
            $request->session()->forget('garage');
            $request->session()->forget('vehicle');
            $request->session()->forget('assigned_user_id');
        }

        return view('fleet.repair_orders.create');
    }

    public function store(RepairOrderRequest $request)
    {
        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        if (Auth::user()->fleet->repair_order_needs_authorization) {
            $state = RepairOrderState::PENDING_AUTHORIZATION;
        } else {
            $state = RepairOrderState::AUTHORIZED;
        }

        $order = new RepairOrder();
        $order->reference = RepairOrderReferenceGenerator::generate(Auth::user()->fleet);
        $order->fleet_id = Auth::user()->fleet->id;
        $order->state_id = $state;
        $order->type = $request->type;
        $order->vehicle_id = $request->vehicle_id;
        $order->garage_id = $request->garage_id;
        $order->creator_user_id = Auth::user()->id;
        $order->garage_hourly_fare = Garage::findOrFail($request->garage_id)->hourly_price;
        $order->kms = $vehicle->kms;
        $order->work_hours_chassis = $vehicle->chassis_can_work_hours ?? $vehicle->chassis_gps_work_hours;
        $order->work_hours_equipment = $vehicle->equipment_work_hours;
        $order->assigned_user_id = [(int)session('assigned_user_id')];

        if ($state == RepairOrderState::AUTHORIZED) {
            $order->authorized_at = now();
        }

        $order->save();

        RapairOrderStateService::transit($order->id, $state);

        $request->session()->forget('garage');
        $request->session()->forget('vehicle');
        $request->session()->forget('assigned_user_id');

        event(new RepairOrderCreated($order));

        if (! Auth::user()->fleet->module_OR) {
            return redirect()->route('fleet.repair-orders.store-simplified', $order);
        } else {
            return redirect()->route('fleet.repair-orders.maintenance-plans.index', $order);
        }
    }

    public function update(UpdateRepairOrderRequest $request, RepairOrder $repairOrder)
    {
        $data = $request->toArray();

        if (isset($data['assigned_user_id'])) {
            $data['assigned_user_id'] = array_map('intval', $data['assigned_user_id']);
        }

        if (isset($data['assigned_user_id']) && $data['assigned_user_id'] != null && $repairOrder->assigned_user_id[0] == 0) {
            $repairOrder->update($data);
            event(new MechanicAssignedToOrder($repairOrder->fresh()));
        } else {
            $repairOrder->update($data);
        }

        return back()->with('success_message', 'Datos actualizados');
    }

    public function updateState(Request $request, RepairOrder $repairOrder)
    {
        
        if ($request->state_id) {

            if($request->state_id == RepairOrderState::MAINTENANCE){
                return FleetRepairOrdersController::finish($repairOrder,RepairOrderState::MAINTENANCE);
            }
            
            if ($request->state_id == RepairOrderState::ITV_PAPER_RECEIVED_BY_GARAGE) {
                return back()->with('success_message', 'Estado actualizado')->with('alert', 'Modificar nueva fecha ITV en base a documentación ITV adjunta');
            }

            RapairOrderStateService::transit($repairOrder->id, $request->state_id);
        
            return back()->with('success_message', 'Estado actualizado');
        }
    }

    public function vehicle(RepairOrder $repairOrder)
    {
        return view('fleet.repair_orders.vehicle', [
            'repair_order' => $repairOrder,
        ]);
    }

    public function garage(RepairOrder $repairOrder)
    {
        return view('fleet.repair_orders.garage', [
            'repair_order' => $repairOrder,
            'garages' => Garage::where('fleet_id', Auth::user()->fleet->id)->orderBy('name')->get(),
        ]);
    }

    public function destroy(RepairOrder $repairOrder)
    {
        RapairOrderStateService::transit($repairOrder->id, RepairOrderState::CANCELED);
        $repairOrder->delete();

        return redirect()
                ->route('fleet.repair-orders.index')
                ->with('success_message', 'OR eliminada');
    }

    public function finish(RepairOrder $repairOrder, $orderState=RepairOrderState::FINISHED)
    {   
        $repairOrder->operations->filter(function ($operation) {
            return ! $operation->isCompleted();
        })->each(function ($operation) {
            $operation->update([
                'user_id' => Auth::user()->id,
                'real_time_in_hours' => $operation->estimated_time_in_hours,
                'completed_at' => new \DateTime,
            ]);
        });
        

        RapairOrderStateService::transit($repairOrder->id, $orderState);
        if($orderState==RepairOrderState::MAINTENANCE){            
            return back()->with('success_message', 'En mantenimiento');
        }
        return back()->with('success_message', 'OR finalizada');
    }


    public function authorization(RepairOrder $repairOrder)
    {
        return view('fleet.repair_orders.authorization', [
            'repair_order' => $repairOrder,
        ]);
    }

    public function authorizeRepairOrder(Request $request, RepairOrder $repair_order)
    {
        if ($repair_order->isAuthorized()) {
            return back()->with('error_message', 'La orden ya ha sido autorizada previamente');
        }

        try {
            DB::beginTransaction();

            $repair_order->update([
                'remarks' => $request->remarks,
                'authorized_at' => Carbon::now(),
                'authorizer_user_id' => Auth::user()->id,
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

    public function pdf(RepairOrder $repair_order)
    {
        $html = view('garage.repair_orders.operations.pdf', [
            'repair_order' => $repair_order,
            'operations' => $repair_order->operations,
        ]);

        return $html;
    }

    public function updateItv(Request $request, RepairOrder $repairOrder)
    {
        if ($request->scheduled_itv_date) {
            $repairOrder->update(['scheduled_itv_date' => $request->scheduled_itv_date]);
            RapairOrderStateService::transit($repairOrder->id, RepairOrderState::ITV_APPOINTMENT_ARRANGED);

            return back()->with('success_message', 'Fecha ITV actualizada');
        }

        return back();
    }

    private function generateAlerts(RepairOrder $repair_order)
    {
        /*$alertService = new AlertService;

        $alertService->to($repair_order->garage)->forVehicle($repair_order->vehicle)->notify(
            "Solicitud de mantenimiento #{$repair_order->id}",
            'Tienes disponible un nuevo mantenimiento para el vehículo',
            "/garage/repair-orders/{$repair_order->id}",
            AlertType::MAINTENANCE
        );*/
    }
}
