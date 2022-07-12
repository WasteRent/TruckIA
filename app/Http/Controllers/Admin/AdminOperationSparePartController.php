<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use App\Models\SparePart;
use Illuminate\Http\Request;

class AdminOperationSparePartController extends Controller
{
    public function index(Operation $operation)
    {
        $spare_parts = $operation->sparePartsGrouped();

        return view('admin.operations.spare_parts.index', [
            'operation' => $operation,
            'spare_parts' => $spare_parts,
        ]);
    }

    public function search(Request $request, int $operation_id)
    {
        $operation = Operation::findOrFail($operation_id);

        $spare_parts = $operation->sparePartsGrouped();

        $filters = SparePart::filters($request->all());
        $spare_parts_search = SparePart::where($filters)->get();

        return view('admin.operations.spare_parts.index', [
            'operation' => $operation,
            'spare_parts' => $spare_parts,
            'spare_parts_search' => $spare_parts_search,
        ]);
    }

    public function store(Request $request, Operation $operation)
    {
        $operation->spareParts()->attach($request->spare_part_id);

        return redirect()->route('admin.operations.spare-parts.index', $operation)
            ->with('success_message', 'Recambio añadido a la operación');
    }

    public function destroy(Operation $operation, SparePart $spare_part)
    {
        $operation->spareParts()->detach($spare_part);

        return redirect()->route('admin.operations.spare-parts.index', $operation)
            ->with('success_message', 'Recambio eliminado de la operación');
    }
}
