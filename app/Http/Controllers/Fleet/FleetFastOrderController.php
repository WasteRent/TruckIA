<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\RapairOrderStateService;
use App\Classes\RepairOrderReferenceGenerator;
use App\Events\RepairOrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Garage;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use App\Models\RepairOrderPart;
use App\Models\RepairOrderState;
use App\Models\Vehicle;
use App\Models\VehicleIncident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FleetFastOrderController extends Controller
{
    public function create(Request $request)
    {
        $request->validate(['vehicle_id' => 'required']);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $user = Auth::user();

        $notes = $request->incident_id ? VehicleIncident::findOrFail($request->incident_id)->incidence : '';

        return view('fleet.repair_orders.fast_orders.create', [
            'vehicle' => $vehicle,
            'garages' => Garage::where('fleet_id', auth()->user()->fleet->id)->orderByDesc('is_manager')->get(),
            'user' => $user,
            'incident_id' => $request->incident_id ?? null,
            'notes' => $notes,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required',
            'vehicle_id' => 'required',
            'garage_id' => 'required',
            'kms' => 'required',
            'work_hours_chassis' => 'required',
            'work_hours_equipment' => 'required',
            'type' => 'required',
            'internal_notes' => 'nullable',
            'created_at' => 'nullable',
            'assigned_user_id' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            if (Auth::user()->fleet->repair_order_needs_authorization) {
                $state = RepairOrderState::PENDING_AUTHORIZATION;
            } else {
                $state = RepairOrderState::AUTHORIZED;
            }

            $order = new RepairOrder();
            $order->fleet_id = Auth::user()->fleet->id;
            $order->reference = RepairOrderReferenceGenerator::generate(Auth::user()->fleet);
            $order->state_id = $state;
            $order->type = $data['type'];
            $order->vehicle_id = $data['vehicle_id'];
            $order->garage_id = $data['garage_id'];
            $order->creator_user_id = Auth::user()->id;
            $order->kms = $data['kms'];
            $order->work_hours_chassis = $data['work_hours_chassis'];
            $order->work_hours_equipment = $data['work_hours_equipment'];
            $order->assigned_user_id = [auth()->id()];
            $order->internal_notes = $data['internal_notes'] ?? '';
            $order->related_incident_id = $request->incident_id;
            $order->created_at = $request->created_at;

            if ($state == RepairOrderState::AUTHORIZED) {
                $order->authorized_at = now();
            }

            $order->save();

            RapairOrderStateService::transit($order->id, $state);

            $this->createLines($order, $request->toArray());

            event(new RepairOrderCreated($order));

            DB::commit();

            return redirect()->route('fleet.repair-orders.show', $order);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function createLines(RepairOrder $repairOrder, array $data)
    {
        foreach ($data['line_description'] as $key => $description) {
            $amount = $data['line_amount'][$key];

            if ($data['line_type'][$key] == 'work-time' && $description) {
                RepairOrderOperation::create([
                    'real_time_in_hours' => $data['line_time'][$key],
                    'repair_order_id' => $repairOrder->id,
                    'amount' => $amount,
                    'operation_name' => $description,
                    'operation_code' => $data['operation_code'][$key],
                ]);
            } elseif ($data['line_type'][$key] == 'spare-part') {
                RepairOrderPart::create([
                    'manufacturer' => isset($data['line_manufacturer'][$key]) ? $data['line_manufacturer'][$key] : '',
                    'repair_order_id' => $repairOrder->id,
                    'total_price' => $amount,
                    'description' => $description,
                    'reference' => $data['line_reference'][$key],
                    'quantity' => $data['line_quantity'][$key],
                ]);
            }
        }
    }
}
