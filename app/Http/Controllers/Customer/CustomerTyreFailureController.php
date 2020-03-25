<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Failure;
use App\Models\Vehicle;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerTyreFailureController extends Controller
{

    public function create(Vehicle $vehicle)
    {
        return view('customer.failures.tyres.create', ['vehicle' => $vehicle]);
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $customer = $vehicle->customers->first();
        $message = "{$request->failure} - {$request->observations}";
        $message .= $customer ? "{$customer->name} {$customer->contact1}":"";

        Failure::create([
            'reporter_user_id' => Auth::user()->id,
            'vehicle_id' => $vehicle->id,
            'failure_type_id' => 24,
            'observations' => $message,
            'phone' => $customer ? $customer->phone1:''
        ]);

        $vehicle->fleet->notify(
            $vehicle->id,
            'Neumáticos en mal estado',
            $message
        );

        User::where('role', 'admin')->get()->each->notify(
            $vehicle->id,
            'Neumáticos en mal estado',
            $message
        );

        return redirect()->route('customer.preventives.index')->with('success_message', 'Estado de neumáticos notificado con éxito');
    }
}
