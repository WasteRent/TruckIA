<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use App\Models\RepairOrder;
use Illuminate\Http\Request;

class FleetCalendarController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? date('Y');
        $month = $request->month ?? date('m');

        $appointments = RepairOrder::filter($request->toArray())
                ->with('vehicle', 'garage')
                ->where('fleet_id', auth()->user()->fleet->id)
                ->whereMonth('appointment', $month)
                ->whereYear('appointment', $year)
                ->orderBy('appointment', 'asc')
                ->get()
                ->map(function ($or) {
                    return (object) [
                        'date' => $or->appointment,
                        'order' => $or,
                    ];
                });

        $events = CalendarEvent::where('user_id', auth()->id())
                    ->whereMonth('datetime', $month)
                    ->whereYear('datetime', $year)
                    ->orderBy('datetime', 'asc')
                    ->get();

        return view('fleet.calendar.index', [
            'items' => $appointments->sortBy('date'),
            'events' => $events,
        ]);
    }

    public function create()
    {
        return view('fleet.calendar.create');
    }

    public function store(Request $request)
    {
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
