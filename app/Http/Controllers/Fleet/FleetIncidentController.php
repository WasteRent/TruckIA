<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\VehicleIncident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetIncidentController extends Controller
{
    public function index(Request $request)
    {
        $users = VehicleIncident::whereNull('closed_at')->whereHas('vehicle', function ($q) {
            $q->where('fleet_id', Auth::user()->fleet->id);
        })->get()->map(function ($incident) {
            return $incident->user;
        })->unique();

        $incidents = VehicleIncident::filter($request->toArray())
                ->whereNull('closed_at')
                ->whereHas('vehicle', function ($q) {
                    $q->where('fleet_id', Auth::user()->fleet->id)
                        ->orWhereHas('guestFleet', function($q2) {
                            $q2->where('fleet_id', Auth::user()->fleet->id);
                        });
                })
                ->orderByDesc('id')
                ->get();

        return view('fleet.incidents.index', [
            'incidents' => $incidents,
            'users' => $users,
        ]);
    }
}
