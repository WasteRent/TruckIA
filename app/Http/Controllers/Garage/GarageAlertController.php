<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Illuminate\Support\Facades\Auth;

class GarageAlertController extends Controller
{

    public function index()
    {
        return view('garage.alerts.index', [
            'alerts' => Alert::where('user_id', Auth::user()->id)->get()
        ]);
    }
}
