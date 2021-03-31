<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleNoteRequest;
use App\Models\Vehicle;
use App\Models\VehicleNote;
use App\Models\VehicleIncident;
use Illuminate\Support\Facades\Auth;

class FleetVehicleNoteController extends Controller
{

    public function index(Vehicle $vehicle)
    {
        return view('fleet.vehicles.notes.index', [
            'vehicle' => $vehicle
        ]);
    }

    public function store(VehicleNoteRequest $request, Vehicle $vehicle)
    {
        $note = new VehicleNote($request->all());
        $note->user_id = Auth::user()->id;
        $vehicle->notes()->save($note);
        return back()->with('success_message', 'Nota añadida');
    }

    public function update(VehicleNoteRequest $request, Vehicle $vehicle, int $note_id)
    {
        VehicleNote::findOrFail($note_id)->update($request->all());
        return back()->with('success_message', 'Nota actualizada');
    }

    public function destroy(Vehicle $vehicle, int $note_id)
    {
        VehicleNote::findOrFail($note_id)->delete();
        return back()->with('success_message', 'Nota eliminada');
    }
}
