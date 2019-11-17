<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaintenanceOperationRequest;
use App\Models\MaintenanceOperation;

class AdminMaintenanceOperationController extends Controller
{

    public function update(MaintenanceOperationRequest $request, int $operation_id)
    {
        MaintenanceOperation::findOrFail($operation_id)->update($request->all());
        return back()->with('success_message', 'Operación actualizada');
    }

    public function destroy(int $operation_id)
    {
        MaintenanceOperation::destroy($operation_id);
        return back()->with('success_message', 'Operación eliminada');
    }
}
