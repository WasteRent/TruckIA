<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\VehicleIncident;
use Illuminate\Http\Request;

class GarageIncidentController extends Controller
{
    public function index(Request $request)
    {
        $incidents = VehicleIncident::filter($request->toArray())
                ->whereNull('closed_at')
                ->whereHas('vehicle', function ($q) {
                    $q->where('fleet_id', auth()->user()->garage->fleet->id)
                        ->orWhereHas('guestFleet', function($q2) {
                            $q2->where('fleet_id', auth()->user()->garage->fleet->id);
                        });
                })
                ->latest()
                ->get();


        return view('garage.incidents.index', [
            'incidents' => $incidents
        ]);
    }
}
