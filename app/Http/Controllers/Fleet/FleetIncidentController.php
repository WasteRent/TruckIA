<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\VehicleIncident;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FleetIncidentController extends Controller
{

    public function index(Request $request)
    {
        $users = VehicleIncident::whereNull('closed_at')->get()->map(function($incident) {
            return $incident->user;
        })->unique();

        return view('fleet.incidents.index', [
            'incidents' => VehicleIncident::filter($request->toArray())->whereNull('closed_at')->latest()->get(),
            'users' => $users
        ]);
    }
}
