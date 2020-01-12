<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OperationRequest;
use App\Models\Operation;
use App\Models\OperationFamily;
use App\Models\OperationSubfamily;
use Illuminate\Http\Request;

class AdminOperationController extends Controller
{
    public function index(Request $request)
    {
        $filters = Operation::filters($request->all());
        $operations = Operation::where($filters)->orderBy('code')->get();

        return view('admin.operations.index', [
            'operations' => $operations
        ]);
    }

    public function create()
    {
        return view('admin.operations.create', [
            'families' => OperationFamily::all(),
            'subfamilies' => OperationSubfamily::all()
        ]);
    }

    public function edit(Operation $operation)
    {
        return view('admin.operations.edit', [
            'operation' => $operation,
            'families' => OperationFamily::all(),
            'subfamilies' => OperationSubfamily::all()
        ]);
    }

    public function store(OperationRequest $request)
    {
        $operation = new Operation($request->all());
        $operation->save();
        return redirect()->route('admin.operations.index')->with('success_message', 'Operación creada');
    }

    public function update(OperationRequest $request, Operation $operation)
    {
        $operation->update($request->all());
        return redirect()->route('admin.operations.index')->with('success_message', 'Operación actualizada');
    }
}
