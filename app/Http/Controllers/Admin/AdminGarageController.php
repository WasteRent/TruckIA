<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Garage;

class AdminGarageController extends Controller
{

    public function index()
    {
        return view('admin.garages.index', [
            'garages' => Garage::all()
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show(Garage $garage)
    {
        return view('admin.garages.show', [
            'garage' => $garage
        ]);
    }


    public function edit(Garage $garage)
    {
        //
    }


    public function update(GarageRequest $request, Garage $garage)
    {
        $garage->update($request->all());
        return back()->with('success_message', 'Taller actualizado');
    }


    public function destroy(Garage $garage)
    {
        //
    }
}
