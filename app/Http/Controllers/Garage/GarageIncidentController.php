<?php

namespace App\Http\Controllers\Garage;

use App\Events\IncidentOpened;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleIncident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


    public function create() {
        return view('garage.incidents.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'incidence' => 'required',
            'created_at' => 'required',
            'plate' => 'required',
        ]);

        $vehicle = Vehicle::where('plate', $data['plate'])
                        ->where('fleet_id', auth()->user()->garage->fleet->id)
                        ->first();

        if ($vehicle) {
            $incident = VehicleIncident::create([
                'user_id' => Auth::user()->id,
                'incidence' => $data['incidence'],
                'created_at' => $data['created_at'],
                'vehicle_id' => $vehicle->id
            ]);

            event(new IncidentOpened($incident));

            return to_route('garage.incidents.index')->with('success_message', 'Incidencia añadida');
        } else {
            return back()->with('error_message', 'Matricula no encontrada');
        }
    }
}
