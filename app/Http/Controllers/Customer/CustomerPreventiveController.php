<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Preventive;
use Illuminate\Support\Facades\Auth;

class CustomerPreventiveController extends Controller
{

    public function index()
    {
        return view('customer.preventives.index', [
            'preventives' => Auth::user()->customer->preventives
        ]);
    }

    public function show(Preventive $preventive)
    {
        return view('customer.preventives.show', [
            'preventive' => $preventive
        ]);
    }
}
