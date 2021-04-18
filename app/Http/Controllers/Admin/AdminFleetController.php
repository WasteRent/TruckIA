<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FleetRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Fleet;
use App\User;

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
        $user = new User([
            'name' => $request->name,
            'username' => $request->name,
            'password' => Hash::make($request->input('name')),
            'email' => $request->notifications_email,
            'is_active' => '1',
            'entity_relation_id' => Auth::user()->id,
            'role' => 'fleet'
        ]);
        $user->save();
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
        try {
            $fleet->delete();
        } catch (\Exception $e) {
            return back()->with('error_message', 'Esta flota tiene vehículos asociados.');
        }
        
        return back()->with('success_message', 'Flota eliminada');
    }
}
