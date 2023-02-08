<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use App\Models\RepairOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetCalendarController extends Controller
{
    public function index(Request $request)
    {
        $appointments = RepairOrder::filter($request->toArray())
                ->with('vehicle', 'garage')
                ->where('fleet_id', auth()->user()->fleet->id)
                ->where('appointment', ">=", today()->subDays(1))
                ->orderBy('appointment', 'asc')
                ->get()
                ->map(function($or){
                    return (object)[
                        'date' => $or->appointment,
                        'order' => $or
                    ];
                });

        $events = CalendarEvent::where('user_id', auth()->id())
                    ->where('datetime', ">=", now())
                    ->orderBy('datetime', 'asc')
                    ->get();
        
        return view('fleet.calendar.index', [
            'appointments' => $appointments,
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
