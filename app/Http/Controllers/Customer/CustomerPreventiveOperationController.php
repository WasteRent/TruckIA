<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Preventive;
use App\Models\PreventiveOperation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPreventiveOperationController extends Controller
{
    public function update(Request $request, Preventive $preventive, PreventiveOperation $operation)
    {
        if ($request->completed) {
            $operation->update(['completed_at' => new \DateTime]);
        }

        if ($preventive->operations()->whereNull('completed_at')->count() == 0) {
            $preventive->update(['finished_at' => new \DateTime]);
        }

        return back()->with('success_message', 'Operación completada');
    }
}
