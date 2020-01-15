<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use App\Models\RepairOrder;
use Illuminate\Http\Request;

class AdminRepairOrderOperationController extends Controller
{

    public function index(Request $request, RepairOrder $repair_order)
    {
        $filters = Operation::filters($request->all());
        $operations_search = Operation::where($filters)->orderBy('code')->get();

        return view('admin.repair_orders.operations.index', [
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

        $repair_order->operations()->attach($request->operation_id);

        return redirect()->route('admin.repair-orders.operations.index', $repair_order)
            ->with('success_message', 'Operación añadida correctamente');
    }


    public function destroy(RepairOrder $repair_order, Operation $operation)
    {
        $repair_order->operations()->detach($operation);

        return redirect()->route('admin.repair-orders.operations.index', $repair_order)
            ->with('success_message', 'Operación eliminada correctamente');
    }
}
