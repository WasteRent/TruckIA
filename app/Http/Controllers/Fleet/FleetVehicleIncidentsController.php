<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleNoteRequest;
use App\Models\Vehicle;
use App\Models\VehicleNote;
use Illuminate\Support\Facades\Auth;

class FleetVehicleIncidentController extends Controller
{

    public function store(VehicleIncidentRequest $request, Vehicle $vehicle)
    {
        $note = new VehicleNote($request->all());
        $note->user_id = Auth::user()->id;
        $vehicle->notes()->save($note);
        return back()->with('success_message', 'Nota añadida');
    }

    public function update(VehicleIncidentRequest $request, Vehicle $vehicle, int $incident_id)
    {
        VehicleNote::findOrFail($incident_id)->update($request->all());
        return back()->with('success_message', 'Nota actualizada');
    }

    public function destroy(Vehicle $vehicle, int $incident_id)
    {
        VehicleNote::findOrFail($note_id)->delete();
        return back()->with('success_message', 'Nota eliminada');
    }
}
