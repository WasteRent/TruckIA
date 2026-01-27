<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleIncident;
use Illuminate\Http\Request;

class VehicleIncidentController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = VehicleIncident::with(['vehicle'])
            ->whereHas('vehicle', function ($q) use ($user) {
                $q->where('fleet_id', $user->fleet->id);
            });

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->has('state')) {
            if ($request->state === 'open') {
                $query->whereNull('closed_at');
            } elseif ($request->state === 'closed') {
                $query->whereNotNull('closed_at');
            }
        }

        $incidents = $query->latest('created_at')->get();

        $data = $incidents->map(function ($incident) {
            return [
                'vehicle' => [
                    'id' => $incident->vehicle->id,
                    'plate' => $incident->vehicle->plate,
                    'internal_id' => $incident->vehicle->internal_id,
                ],
                'incident' => [
                    'id' => $incident->id,
                    'state' => $incident->closed_at ? 'closed' : 'open',
                    'description' => $incident->incidence,
                    'created_at' => $incident->created_at ?? null,
                    'closed_at' => $incident->closed_at ?? null,
                ],
            ];
        })->toArray();

        return response()->json(['data' => $data], 200);
    }
}
