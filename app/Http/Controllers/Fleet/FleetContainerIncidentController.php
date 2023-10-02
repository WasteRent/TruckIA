<?php

namespace App\Http\Controllers\Fleet;

use App\Events\IncidentClosed;
use App\Events\IncidentOpened;
use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\ContainerIncident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetContainerIncidentController extends Controller
{
    public function index(Request $request, Container $container)
    {
        $incidents = ContainerIncident::filter($request->toArray())->whereHas('container', function($q) use ($container) {
            $q->where('id', $container->id);
        })->latest()->get();

        return view('fleet.containers.incidents.index', [
            'container' => $container,
            'incidents' => $incidents
        ]);
    }

    public function store(Request $request, Container $container)
    {
        $request->validate(['incidence' => 'required']);

        $incident = new ContainerIncident($request->all());
        $incident->user_id = Auth::user()->id;
        $container->incidents()->save($incident);

        return back()->with('success_message', 'Incidencia añadida');
    }

    public function update(Request $request, Container $container, int $incident_id)
    {
        if (isset($request["incidence_{$incident_id}"])) {
            ContainerIncident::findOrFail($incident_id)->update([
                'incidence' => $request["incidence_{$incident_id}"],
            ]);
        }
        if (isset($request["incidence_date_{$incident_id}"])) {
            ContainerIncident::findOrFail($incident_id)->update([
                'created_at' => $request["incidence_date_{$incident_id}"],
            ]);
        }
        if (isset($request["mechanic_user_id_{$incident_id}"]) && !empty($request["mechanic_user_id_{$incident_id}"])) {
            ContainerIncident::findOrFail($incident_id)->update([
                'user_id' => $request["mechanic_user_id_{$incident_id}"]
            ]);
        }
        if (isset($request['closed_at'])) {
            ContainerIncident::findOrFail($incident_id)->update([
                'closed_at' => now(),
            ]);
        }
        if (isset($request['reopen'])) {
            ContainerIncident::findOrFail($incident_id)->update([
                'closed_at' => null,
            ]);
        }

        return back()->with('success_message', 'Incidencia actualizada');
    }

    public function destroy(Container $container, int $incident_id)
    {
        ContainerIncident::findOrFail($incident_id)->delete();

        return back()->with('success_message', 'Incidencia eliminada');
    }
}
