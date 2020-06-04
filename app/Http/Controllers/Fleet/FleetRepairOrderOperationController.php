<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use Illuminate\Http\Request;

class FleetRepairOrderOperationController extends Controller
{

    public function index(Request $request, RepairOrder $repair_order)
    {
        return view('fleet.repair_orders.operations.index', [
            'repair_order' => $repair_order,
            'operations' => $repair_order->operations
        ]);
    }

    public function search(Request $request, RepairOrder $repair_order)
    {
        $operations_search = Operation::search($request->search)->get()->map(function ($item) {
            $item->name = $item->scoutMetadata()['_highlightResult']['name']['value'];
            if (isset($item->scoutMetadata()['_highlightResult']['description'])) {
                $item->description = $item->scoutMetadata()['_highlightResult']['description']['value'];
            }
            return $item;
        });

        return view('fleet.repair_orders.operations.search_results', [
            'operations_search' => $operations_search,
            'repair_order' => $repair_order
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
