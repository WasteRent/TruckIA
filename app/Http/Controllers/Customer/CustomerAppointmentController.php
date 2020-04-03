<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerAppointmentController extends Controller
{

    public function index()
    {
        $appointments = Auth::user()->customer->vehicles->flatMap->appointments->filter(function ($appointment) {
            return $appointment->date_time > new \DateTime;
        });
        return view('customer.appointments.index', [
            'appointments' => $appointments
        ]);
    }
}
