<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FleetRequest;
use App\Models\Fleet;

class AdminFleetController extends Controller
{

    public function index()
    {
        return view('admin.fleets.index', [
            'fleets' => Fleet::all()
        ]);
    }

    public function create()
    {
        return view('admin.fleets.create');
    }

    public function store(FleetRequest $request)
    {
        $fleet = new Fleet($request->all());
        $fleet->save();
        return redirect()->route('admin.fleets.index')->with('success_message', 'Flota creada');
    }

    public function show(Fleet $fleet)
    {
        return view('admin.fleets.show', [
            'fleet' => $fleet
        ]);
    }

    public function edit(Fleet $fleet)
    {
        return view('admin.fleets.edit', [
            'fleet' => $fleet
        ]);
    }

    public function update(FleetRequest $request, Fleet $fleet)
    {
        $fleet->update($request->all());
        return redirect()->route('admin.fleets.index')->with('success_message', 'Flota actualizada');
    }

    public function destroy(Fleet $fleet)
    {
        //
    }
}
