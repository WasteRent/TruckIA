<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'plate' => 'required|string',
            'incident' => 'required|string',
        ]);
        try {
            Incident::create($data);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el incidente: ' . $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Incidente creado correctamente'], 200);
    }
}
