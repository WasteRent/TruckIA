<?php

namespace App\Http\Controllers\Customer;

use App\Classes\AlertService;
use App\Http\Controllers\Controller;
use App\Models\AlertType;
use App\Models\Failure;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerTyreFailureController extends Controller
{
    public function create(Vehicle $vehicle)
    {
        return view('customer.failures.tyres.create', ['vehicle' => $vehicle]);
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $customer = $vehicle->customer;
        $message = "{$request->failure} - {$request->observations}";
        $message .= $customer ? "{$customer->name} {$customer->contact1}" : '';

        $failure = Failure::create([
            'reporter_user_id' => Auth::user()->id,
            'vehicle_id' => $vehicle->id,
            'failure_type_id' => 24,
            'observations' => $message,
            'phone' => $customer ? $customer->phone1 : '',
        ]);

        (new AlertService)->to($vehicle->fleet)->forVehicle($vehicle)->notify(
            'Nueva avería reportada',
            "Neumáticos en mal estado, {$failure->type->name}, {$request->observations}, Contacto: {$request->phone}",
            null,
            AlertType::FAILURE
        );

        return redirect()->route('customer.preventives.index')->with('success_message', 'Estado de neumáticos notificado con éxito');
    }
}
