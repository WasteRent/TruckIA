<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\RapairOrderStateService;
use App\Events\RepairOrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Garage;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use App\Models\RepairOrderPart;
use App\Models\RepairOrderState;
use App\Models\Vehicle;
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

        try {
            $garage = $user->garage;
        } catch (\Exception $e) {
            $garage = Garage::where('is_manager', 1)->first();
        }

        return view('fleet.repair_orders.fast_orders.create', [
            'vehicle' => $vehicle,
            'garage' => $garage,
            'user' => $user,
        ]);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'type' => 'required',
            'vehicle_id' => 'required',
            'garage_id' => 'required',
            'kms' => 'required',
            'work_hours_chassis' => 'required',
            'work_hours_equipment' => 'required',
            'internal_notes' => 'nullable',
            'line_type' => 'nullable',
            'line_description' => 'nullable',
            'line_amount' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            $order = new RepairOrder();
            $order->fleet_id = Auth::user()->fleet->id;
            $order->state_id = RepairOrderState::PENDING_AUTHORIZATION;
            $order->type = $data['type'];
            $order->vehicle_id = $data['vehicle_id'];
            $order->garage_id = $data['garage_id'];
            $order->creator_user_id = Auth::user()->id;
            $order->kms = $data['kms'];
            $order->work_hours_chassis = $data['work_hours_chassis'];
            $order->work_hours_equipment = $data['work_hours_equipment'];
            $order->assigned_user_id = Auth::user()->id;
            $order->internal_notes = $data['internal_notes'];
            $order->save();

            $this->createLines($order, $data);

            event(new RepairOrderCreated($order));

            DB::commit();

            return redirect()->route('fleet.repair-orders.show', $order);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function createLines(RepairOrder $repairOrder, array $data) {
        foreach ($data['line_description'] as $key => $description) {
            $amount = $data['line_amount'][$key];

            if ($data['line_type'][$key] == 'work') {
                RepairOrderOperation::create([
                    'repair_order_id' => $repairOrder->id,
                    'amount' => $amount,
                    'operation_name' => $description
                ]);
            }
            elseif ($data['line_type'][$key] == 'part') {
                RepairOrderPart::create([
                    'repair_order_id' => $repairOrder->id,
                    'total_price' => $amount,
                    'description' => $description
                ]);
            }
        }
    }
}
