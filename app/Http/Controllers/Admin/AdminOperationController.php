<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OperationRequest;
use App\Mail\OperationDetailsMail;
use App\Models\Garage;
use App\Models\MaintenancePlan;
use App\Models\Vehicle;
use App\Operation;
use Illuminate\Support\Facades\Mail;

class AdminOperationController extends Controller
{

    public function index()
    {
        return view('admin.operations.index', [
            'operations' => Operation::latest()->get()
        ]);
    }

    public function create()
    {
        return view('admin.operations.create', [
            'vehicles' => Vehicle::all(),
            'garages' => Garage::all(),
            'plans' => MaintenancePlan::all()
        ]);
    }

    public function store(OperationRequest $request)
    {
        $operation = new Operation($request->all());
        $operation->save();

        Mail::to('dramirez@truckts.com')->send(new OperationDetailsMail($operation->fresh()));

        return redirect()
                ->route('admin.operations.show', $operation)
                ->with('success_message', 'Nueva operación creada. Datos enviados al taller.');
    }

    public function show(Operation $operation)
    {
        return view('admin.operations.show', [
            'operation' => $operation
        ]);
    }
}
