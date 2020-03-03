<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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



    // public function update(MaintenancePlanRequest $request, MaintenancePlan $maintenancePlan)
    // {
    //     $maintenancePlan->update($request->all());
    //     return redirect()->route('admin.maintenance-plans.index', $maintenancePlan)
    //                     ->with('success_message', 'Plan de mantenimiento actualizado');
    // }
}
