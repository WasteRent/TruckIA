<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\GarageRequest;
use App\Models\Manufacturer;
use Illuminate\Support\Facades\Auth;

class GarageDetailsController extends Controller
{

    public function index()
    {
        return view('garage.details', [
            'garage' => Auth::user()->garage,
            'manufacturers' => Manufacturer::all()
        ]);
    }

    public function update(GarageRequest $request)
    {
        Auth::user()->garage->update($request->toArray());
        return back()->with('success_message', 'Datos actualizados');
    }
}
