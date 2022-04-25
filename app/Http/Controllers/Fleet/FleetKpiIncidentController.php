<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\VehicleIncident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetKpiIncidentController extends Controller
{
    
    public function index(Request $request)
    {
        $to = $request->to;
        $from = $request->from;

        $data = VehicleIncident::whereHas('vehicle', function($query) {
            $query->where('fleet_id', Auth::user()->fleet->id);
        })->whereBetween('created_at', ["$from 00:00:00", "$to 23:59:59"])->get();

        $data = $data->groupBy('vehicle_id')->map(function($incidents) {
            return [
                'plate' => $incidents->first()->vehicle->plate,
                'incidents' => $incidents->count() 
            ];
        })->sortByDesc(function($item) {
            return $item['incidents'];
        })
        ->values()
        ->toArray();

        return view('fleet.dashboard.incidents', [
            'source' => $data
        ]);
    }
}
