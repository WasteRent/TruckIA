<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleLocation;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $locations = VehicleLocation::where('fleet_id', $user->fleet->id)
            ->orderBy('name')
            ->get();

        $data = $locations->map(function ($location) {
            return [
                'id' => $location->id,
                'name' => $location->name,
            ];
        })->toArray();

        return response()->json(['data' => $data], 200);
    }
}
