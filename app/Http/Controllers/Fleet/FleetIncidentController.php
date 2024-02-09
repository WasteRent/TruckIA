<?php

namespace App\Http\Controllers\Fleet;

use App\Events\IncidentOpened;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
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
                ->latest()
                ->get();

        return view('fleet.incidents.index', [
            'incidents' => $incidents,
            'users' => $users,
        ]);
    }

    public function create() {
        return view('fleet.incidents.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'incidence' => 'required',
            'created_at' => 'required',
            'plate' => 'required',
        ]);

        $vehicle = Vehicle::where('plate', $data['plate'])
                        ->where('fleet_id', Auth::user()->fleet->id)
                        ->first();

        if ($vehicle) {
            $incident = VehicleIncident::create([
                'user_id' => Auth::user()->id,
                'incidence' => $data['incidence'],
                'created_at' => $data['created_at'],
                'vehicle_id' => $vehicle->id
            ]);

            event(new IncidentOpened($incident));

            return to_route('fleet.incidents.index')->with('success_message', 'Incidencia añadida');
        } else {
            return back()->with('error_message', 'Matricula no encontrada');
        }
    }


}
