<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SpecialityRequest;
use App\Models\Garage;
use App\Models\Speciality;

class AdminGarageSpecialitiesController extends Controller
{


    public function index(Garage $garage)
    {
        return view('admin.garages.specialities', [
            'garage' => $garage,
            'specialities' => Speciality::all(),
            'garage_specialities' => $garage->specialities
        ]);
    }


    public function update(SpecialityRequest $request, Garage $garage, Speciality $speciality)
    {
        if ($garage->specialities->contains($speciality)) {
            $garage->specialities()->updateExistingPivot($speciality->id, ['stars' => $request->stars]);
        } else {
            $garage->specialities()->attach($speciality->id, ['stars' => $request->stars]);
        }

        return back()->with('success_message', 'Datos actualizados');
    }
}
