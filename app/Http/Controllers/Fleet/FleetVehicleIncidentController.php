<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleIncidentRequest;
use App\Models\Vehicle;
use App\Models\VehicleIncident;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FleetVehicleIncidentController extends Controller
{

    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.incidents.index', [
            'vehicle' => $vehicle
        ]);
    }

    public function store(VehicleIncidentRequest $request, Vehicle $vehicle)
    {
        $incident = new VehicleIncident($request->all());
        $incident->user_id = Auth::user()->id;
        $vehicle->incidents()->save($incident);
        return back()->with('success_message', 'Incidencia añadida');
    }

    public function update(Request $request, Vehicle $vehicle, int $incident_id)
    {
        if (isset($request["incidence_{$incident_id}"])) {
            VehicleIncident::findOrFail($incident_id)->update([
                'incidence' => $request["incidence_{$incident_id}"]
            ]);
        }
        if (isset($request["closed_at"])) {
            VehicleIncident::findOrFail($incident_id)->update([
                'closed_at' => now()
            ]);
        }
        if (isset($request["reopen"])) {
            VehicleIncident::findOrFail($incident_id)->update([
                'closed_at' => null
            ]);
        }
        
        return back()->with('success_message', 'Incidencia actualizada');
    }

    public function destroy(Vehicle $vehicle, int $incident_id)
    {
        VehicleIncident::findOrFail($incident_id)->delete();
        return back()->with('success_message', 'Incidencia eliminada');
    }
}
