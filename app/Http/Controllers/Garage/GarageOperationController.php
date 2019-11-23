<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\FinishOperationRequest;
use App\Models\Operation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GarageOperationController extends Controller
{
    public function index()
    {
        return view('garage.operations.index', [
            'operations' => Auth::user()->garage->operations
        ]);
    }

    public function show(Operation $operation)
    {
        return view('garage.operations.show', [
            'operation' => $operation
        ]);
    }

    public function finish(FinishOperationRequest $request, Operation $operation)
    {
        $operation->finished_at = Carbon::now();
        $operation->completed = true;
        $operation->save();
        return back()->with('success_message', 'Operación completada');
    }
}
