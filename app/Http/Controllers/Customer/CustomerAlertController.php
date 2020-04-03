<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Illuminate\Support\Facades\Auth;

class CustomerAlertController extends Controller
{

    public function index()
    {
        return view('customer.alerts.index', [
            'alerts' => Alert::where('user_id', Auth::user()->id)->latest()->get()
        ]);
    }
}
