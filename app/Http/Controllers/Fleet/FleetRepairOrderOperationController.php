<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\OperationFamily;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use App\Models\UniversalOperation;
use Illuminate\Http\Request;

class FleetRepairOrderOperationController extends Controller
{

    public function index(Request $request, RepairOrder $repair_order)
    {
        $operations_search = [];
        if($request->name  & $request->family_id){
            $operations_search = UniversalOperation::where('name', 'LIKE', "%{$request->name}%")->where('family_id', $request->family_id)->get();
        }
        else{
            if ($request->name) {
            $operations_search = UniversalOperation::where('name', 'LIKE', "%{$request->name}%")->get();
            }
            if ($request->family_id){
            $operations_search = UniversalOperation::where('family_id', $request->family_id)->get();
            }
        }
    
        return view('fleet.repair_orders.operations.index', [
            'repair_order' => $repair_order,
            'operations' => $repair_order->operations,
            'operations_search' => $operations_search,
            'families' => OperationFamily::all()
        ]);
    }

    public function search(Request $request, RepairOrder $repair_order)
    {
        $query = UniversalOperation::search($request->search);

        if ($request->family_id) {
            $query->where('family_id', $request->family_id);
        }
        
        $operations_search = $query->get()->map(function ($item) {
            $item->name = $item->scoutMetadata()['_highlightResult']['name']['value'];
            if (isset($item->scoutMetadata()['_highlightResult']['description'])) {
                $item->description = $item->scoutMetadata()['_highlightResult']['description']['value'];
            }
            return $item;
        });

        return view('fleet.repair_orders.operations.search_results', [
            'add_route' => route('fleet.repair-orders.operations.store', $repair_order),
            'operations_search' => $operations_search,
            'repair_order' => $repair_order
        ]);
    }

    public function store(Request $request, RepairOrder $repair_order)
    {
        $operation = UniversalOperation::findOrFail($request->operation_id);

        $repair_order->operations()->save(new RepairOrderOperation([
            'operation_attachment_file_id' => $operation->attachment_file_id,
            'operation_family' => $operation->family->name,
            'operation_subfamily' => $operation->subfamily->name,
            'operation_name' => $operation->name,
            'operation_description' => $operation->description,
            'estimated_time_in_hours' => $operation->time_in_hours
        ]));

        if(Auth::user()->fleet->module_OR){$route='fleet.repair-orders.operations.index';}else{$route='fleet.repair_orders.store-simplified';}

        return redirect()->route($route, $repair_order)
            ->with('success_message', 'Operación añadida correctamente');
    }


    public function destroy(RepairOrder $repair_order, RepairOrderOperation $operation)
    {
        $operation->delete();

        if(Auth::user()->fleet->module_OR){$route='fleet.repair-orders.operations.index';}else{$route='fleet.repair_orders.store-simplified';}

        return redirect()->route($route, $repair_order)
            ->with('success_message', 'Operación eliminada correctamente');
    }
}
