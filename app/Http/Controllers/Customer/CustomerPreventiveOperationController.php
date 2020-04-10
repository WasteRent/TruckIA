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
            $operation->completed = 1;
            $operation->completed_at = new \DateTime;
            $operation->save();
        }
        return back()->with('success_message', 'Operación completada');
    }
}
