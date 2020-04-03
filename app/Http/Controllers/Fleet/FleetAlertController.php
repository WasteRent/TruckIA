<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Illuminate\Support\Facades\Auth;

class FleetAlertController extends Controller
{

    public function index()
    {
        return view('fleet.alerts.index', [
            'alerts' => Auth::user()->alerts()->latest()->get()
        ]);
    }
}
