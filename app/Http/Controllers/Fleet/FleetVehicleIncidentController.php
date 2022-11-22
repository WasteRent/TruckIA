<?php

namespace App\Http\Controllers\Fleet;

use App\Events\IncidentClosed;
use App\Events\IncidentOpened;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleIncidentRequest;
use App\Models\Vehicle;
use App\Models\VehicleIncident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetVehicleIncidentController extends Controller
{
    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.incidents.index', [
            'vehicle' => $vehicle,
        ]);
    }

    public function store(VehicleIncidentRequest $request, Vehicle $vehicle)
    {
        $incident = new VehicleIncident($request->all());
        $incident->user_id = Auth::user()->id;
        $vehicle->incidents()->save($incident);

        event(new IncidentOpened($incident));

        return back()->with('success_message', 'Incidencia añadida');
    }

    public function update(Request $request, Vehicle $vehicle, int $incident_id)
    {
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
        if (isset($request["mechanic_user_id_{$incident_id}"]) && !empty($request["mechanic_user_id_{$incident_id}"])) {
            VehicleIncident::findOrFail($incident_id)->update([
                'user_id' => $request["mechanic_user_id_{$incident_id}"]
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

    public function destroy(Vehicle $vehicle, int $incident_id)
    {
        VehicleIncident::findOrFail($incident_id)->delete();

        return back()->with('success_message', 'Incidencia eliminada');
    }
}
