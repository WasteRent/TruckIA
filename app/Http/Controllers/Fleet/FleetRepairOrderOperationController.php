<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use Illuminate\Http\Request;

class FleetRepairOrderOperationController extends Controller
{

    public function index(Request $request, RepairOrder $repair_order)
    {
        $filters = Operation::filters($request->all());
        $operations_search = !empty($filters) ? Operation::where($filters)->orderBy('code')->get() : [];

        return view('fleet.repair_orders.operations.index', [
            'repair_order' => $repair_order,
            'operations' => $repair_order->operations,
            'operations_search' => $operations_search
        ]);
    }

    public function store(Request $request, RepairOrder $repair_order)
    {
        if ($repair_order->operations->contains($request->operation_id)) {
            return back()->with('error_message', 'Esta operación ya existe en la orden de reparación');
        }

        $operation = Operation::findOrFail($request->operation_id);

        $repair_order->operations()->save(new RepairOrderOperation([
            'operation_family' => $operation->family->name,
            'operation_subfamily' => $operation->subfamily->name,
            'operation_code' => $operation->code,
            'operation_name' => $operation->name,
            'operation_description' => $operation->description,
            'estimated_time_in_hours' => $operation->time_in_hours
        ]));

        return redirect()->route('fleet.repair-orders.operations.index', $repair_order)
            ->with('success_message', 'Operación añadida correctamente');
    }


    public function destroy(RepairOrder $repair_order, RepairOrderOperation $operation)
    {
        $operation->delete();

        return redirect()->route('fleet.repair-orders.operations.index', $repair_order)
            ->with('success_message', 'Operación eliminada correctamente');
    }
}
