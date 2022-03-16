<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\VehicleIncident;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FleetIncidentController extends Controller
{

    public function index()
    {
        return view('fleet.incidents.index', [
            'incidents' => VehicleIncident::whereNull('closed_at')->latest()->paginate(40)
        ]);
    }
}
