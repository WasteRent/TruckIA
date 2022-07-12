<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerAppointmentController extends Controller
{
    public function index()
    {
        return view('customer.appointments.index', [
            'appointments' => Auth::user()->customer->appointments,
        ]);
    }
}
