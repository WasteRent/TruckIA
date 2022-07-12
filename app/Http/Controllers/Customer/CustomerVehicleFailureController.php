<?php

namespace App\Http\Controllers\Customer;

use App\Classes\AlertService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\FailureRequest;
use App\Models\AlertType;
use App\Models\Failure;
use App\Models\FailureType;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class CustomerVehicleFailureController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        return view('customer.failures.index', [
            'vehicle' => $vehicle,
            'failures' => $vehicle->failures,
        ]);
    }

    public function create(Vehicle $vehicle)
    {
        return view('customer.failures.create', [
            'vehicle' => $vehicle,
            'types' => FailureType::all(),
        ]);
    }

    public function store(FailureRequest $request, Vehicle $vehicle)
    {
        $failure = Failure::create([
            'reporter_user_id' => Auth::user()->id,
            'vehicle_id' => $vehicle->id,
            'failure_type_id' => $request->failure_type_id,
            'observations' => $request->observations,
            'phone' => $request->phone,
        ]);

        (new AlertService)->to($vehicle->fleet)->forVehicle($vehicle)->notify(
            'Nueva avería reportada',
            $failure->type->name.' - '.$request->observations.'. Contacto: '.$request->phone,
            null,
            AlertType::FAILURE
        );

        return redirect()->route('customer.vehicles.failures.index', $vehicle)->with('success_message', 'Avería enviada');
    }
}
