<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use App\Models\RepairOrder;
use App\Models\VehicleIncident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetCalendarController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? date('Y');
        $month = $request->month ?? date('m');

        $appointments = RepairOrder::query()
                ->with('vehicle', 'garage')
                ->where('fleet_id', auth()->user()->fleet->id)
                ->whereMonth('appointment', $month)
                ->whereYear('appointment', $year)
                ->orderBy('appointment', 'asc')
                ->get()
                ->map(function($or){
                    return (object)[
                        'date' => $or->appointment,
                        'order' => $or
                    ];
                });

        $incidents = VehicleIncident::query()
                ->with('vehicle')
                ->whereHas('vehicle', function($q) {
                    $q->where('fleet_id', auth()->user()->fleet->id);
                })
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function($incident){
                    return (object)[
                        'date' => $incident->created_at,
                        'incident' => $incident
                    ];
                });

        $events = CalendarEvent::where('user_id', auth()->id())
                    ->whereMonth('datetime', $month)
                    ->whereYear('datetime', $year)
                    ->orderBy('datetime', 'asc')
                    ->get();
        
        return view('fleet.calendar.index', [
            'items' => $appointments->merge($incidents)->sortBy('date'),
            'events' => $events
        ]);
    }

    public function create() {
        return view('fleet.calendar.create');
    }

    public function store(Request $request) {
        $data = $request->validate(['datetime' => 'required', 'title' => 'required', 'description' => 'nullable']);
        CalendarEvent::create([
            'datetime' => $data['datetime'],
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => auth()->id(),
            'fleet_id' => auth()->user()->fleet->id, 
        ]);
        return to_route('fleet.calendar.index')->with('success_message', 'Evento creado');
    }
}
