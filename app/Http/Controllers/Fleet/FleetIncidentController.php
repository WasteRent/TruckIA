<?php

namespace App\Http\Controllers\Fleet;

use App\Events\IncidentClosed;
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
        $incidents = VehicleIncident::filter($request->toArray())
                ->whereNull('closed_at')
                ->whereHas('vehicle', function ($q) {
                    $q->allowForUser();
                })->latest()->paginate(20);

        if (Auth::user()->job == 'driver') {
            $incidents = collect([]);
        }

        return view('fleet.incidents.index', [
            'incidents' => $incidents,
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

            return to_route('fleet.incidents.index')->with('success_message', 'Incidencia añadida. ID: #' . $incident->id);
        } else {
            return back()->with('error_message', 'Matricula no encontrada');
        }
    }
    
    public function update(Request $request, int $incident_id) {

        if (isset($request["incidence_{$incident_id}"])) {
            VehicleIncident::findOrFail($incident_id)->update([
                'incidence' => $request["incidence_{$incident_id}"],
            ]);
        }
        if (isset($request["incidence_date_{$incident_id}"])) {
            VehicleIncident::findOrFail($incident_id)->update([
                'created_at' => $request["incidence_date_{$incident_id}"],
            ]);
        }
        if (isset($request["mechanic_user_id_{$incident_id}"]) && ! empty($request["mechanic_user_id_{$incident_id}"])) {
            VehicleIncident::findOrFail($incident_id)->update([
                'user_id' => $request["mechanic_user_id_{$incident_id}"],
            ]);
        }
        if (isset($request['closed_at'])) {
            VehicleIncident::findOrFail($incident_id)->update([
                'closed_at' => now(),
            ]);
            event(new IncidentClosed(VehicleIncident::findOrFail($incident_id)));
        }
        if (isset($request['reopen'])) {
            VehicleIncident::findOrFail($incident_id)->update([
                'closed_at' => null,
            ]);
            event(new IncidentOpened(VehicleIncident::findOrFail($incident_id)));
        }

        return back()->with('success_message', 'Incidencia actualizada');
    }


}
