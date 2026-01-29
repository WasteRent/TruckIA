<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleState;
use Illuminate\Http\Request;

class VehicleStateController extends Controller
{
    public function index(Request $request)
    {
        $states = VehicleState::orderBy('name')->get();

        $data = $states->map(function ($state) {
            return [
                'id' => $state->id,
                'name' => $state->name,
            ];
        })->toArray();

        return response()->json(['data' => $data], 200);
    }
}
