<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\FailureRequest;
use App\Models\Failure;
use App\Models\FailureType;
use App\Models\Vehicle;
use App\User;
use Illuminate\Support\Facades\Auth;

class CustomerVehicleFailureController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        return view('customer.failures.index', [
            'vehicle' => $vehicle,
            'failures' => $vehicle->failures
        ]);
    }

    public function create(Vehicle $vehicle)
    {
        return view('customer.failures.create', [
            'vehicle' => $vehicle,
            'types' => FailureType::all()
        ]);
    }

    public function store(FailureRequest $request, Vehicle $vehicle)
    {
        Failure::create([
            'reporter_user_id' => Auth::user()->id,
            'vehicle_id' => $vehicle->id,
            'failure_type_id' => $request->failure_type_id,
            'observations' => $request->observations
        ]);

        $vehicle->fleet->notify(
            $vehicle->id,
            'Nueva avería reportada',
            $request->observations
        );

        User::where('role', 'admin')->get()->each->notify(
            $vehicle->id,
            'Nueva avería reportada',
            $request->observations ?? ''
        );

        return redirect()->route('customer.vehicles.failures.index', $vehicle)->with('success_message', 'Avería enviada');
    }
}
