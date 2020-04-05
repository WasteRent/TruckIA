<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\GarageSpecialityRequest;
use App\Models\Garage;
use App\Models\Speciality;

class FleetGarageSpecialitiesController extends Controller
{


    public function index(Garage $garage)
    {
        return view('fleet.garages.specialities', [
            'garage' => $garage,
            'specialities' => Speciality::all(),
            'garage_specialities' => $garage->specialities
        ]);
    }


    public function update(GarageSpecialityRequest $request, Garage $garage, Speciality $speciality)
    {
        if ($garage->specialities->contains($speciality)) {
            $garage->specialities()->updateExistingPivot($speciality->id, ['stars' => $request->stars]);
        } else {
            $garage->specialities()->attach($speciality->id, ['stars' => $request->stars]);
        }

        return back()->with('success_message', 'Datos actualizados');
    }
}
