<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use Illuminate\Http\Request;

class AdminRepairOrdersController extends Controller
{

    public function index(Request $request)
    {
        $filters = RepairOrder::filters($request->all());
        $repair_orders = RepairOrder::where($filters)->latest()->get();

        return view('admin.repair_orders.index', [
            'repair_orders' => $repair_orders
        ]);
    }

    public function create()
    {
        // return view('admin.operations.create', [
        //     'vehicles' => Vehicle::all(),
        //     'garages' => Garage::all(),
        //     'plans' => MaintenancePlan::all()
        // ]);
    }

    public function store(OperationRequest $request)
    {
        // $operation = new Operation($request->all());
        // $operation->save();

        // Mail::to('dramirez@truckts.com')->send(new OperationDetailsMail($operation->fresh()));
        // Mail::to('tpineiro@truckts.com')->send(new OperationDetailsMail($operation->fresh()));

        // return redirect()
        //         ->route('admin.operations.show', $operation)
        //         ->with('success_message', 'Nueva operación creada. Datos enviados al taller.');
    }

    public function show(Operation $operation)
    {
        return view('admin.operations.show', [
            'operation' => $operation
        ]);
    }
}
