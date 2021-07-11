<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\RapairOrderStateService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\RepairOrderRequest;
use App\Http\Requests\Fleet\UpdateRepairOrderRequest;
use App\Models\Garage;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use App\Models\MaintenancePlan;
use App\Models\RepairOrderState;
use App\Models\RepairOrderPart;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetTestRepairOrdersController extends Controller
{

    public function index(Request $request)
    {
        $filters = RepairOrder::filters($request->all());
        $repair_orders = RepairOrder::where($filters)
                ->where('fleet_id', Auth::user()->fleet->id)
                ->latest()
                ->get();
                
        return view('fleet.test_repair_orders.index', [
            'repair_orders' => $repair_orders,
            'states' => RepairOrderState::all()
        ]);
    }
    
    public function corrective()
    {
        return view('fleet.test_repair_orders.corrective.corrective');
    }

    public function preventive()
    {
        return view('fleet.test_repair_orders.preventive.preventive');
    }

    public function create()
    {
        return view('fleet.test_repair_orders.index');
    }

    public function update(UpdateRepairOrderRequest $request, RepairOrder $repair_order)
    {
        $repair_order->update($request->all());
        return back()->with('success_message', 'Datos actualizados');
    }

    public function enTallerCo(RepairOrder $repair_order)
    {

        return view('fleet.test_repair_orders.corrective.in_garage_corrective', [
            'repair_order' => $repair_order,
            'vehicle' => Vehicle::find($repair_order->vehicle_id)
    ]);
    }
    
    public function enTallerPre()
    {
        return view('fleet.test_repair_orders.preventive.in_garage_preventive');
    }

    public function facturaPendiente()
    {
        return view('fleet.test_repair_orders.corrective.pending_invoice');
    }

    public function pendingJob()
    {
        return view('fleet.test_repair_orders.pending_job');
    }

    public function datosIncompletos(UpdateRepairOrderRequest $request, RepairOrder $repair_order)
    {
        $operations = RepairOrderOperation::where('repair_order_id' ,'=', $repair_order->id)->get();
        $operations_parts = RepairOrderPart::where('repair_order_id' ,'=', $repair_order->id)->get();

        return view('fleet.test_repair_orders.corrective.incomplete_data',[
            'repair_order' => $repair_order,
            'operations' => $operations,
            'operations_parts' => $operations_parts,
            'vehicle' => Vehicle::find($repair_order->vehicle_id)
        ]);
    }

    public function citaPrevTec()
    {
        return view('fleet.test_repair_orders.preventive.cita_preventivo_tecnico');
    }

    public function citaTaller()
    {
        return view('fleet.test_repair_orders.preventive.pendiente_cita_taller');
    }

    public function destroy(RepairOrder $repairOrder)
    {
        RapairOrderStateService::transit($repairOrder->id, RepairOrderState::CANCELED);
        $repairOrder->delete();
        return redirect()
                ->back('fleet.repair-orders.index')
                ->with('success_message', 'OR eliminada');
    }
    
    public function destroyPart(RepairOrderPart $operations_part)
    {
        $operations_part->delete();
        return back()
                ->with('success_message', 'Recambio eliminado.');
    }

    public function destroyOperation(RepairOrderOperation $operation)
    {
        $operation->parts()->delete();
        $operation->delete();

        return back()
            ->with('success_message', 'Operación eliminada correctamente');
    }
}
