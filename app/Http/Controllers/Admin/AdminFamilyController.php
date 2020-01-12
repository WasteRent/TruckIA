<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OperationFamilyRequest;
use App\Models\OperationFamily;

class AdminFamilyController extends Controller
{

    public function index()
    {
        return view('admin.families.index', [
            'families' => OperationFamily::all()
        ]);
    }

    public function create()
    {
        return view('admin.families.create');
    }

    public function store(OperationFamilyRequest $request)
    {
        $fleet = new OperationFamily($request->all());
        $fleet->save();
        return redirect()->route('admin.families.index')->with('success_message', 'Familia creada');
    }


    public function edit(OperationFamily $family)
    {
        return view('admin.families.edit', [
            'family' => $family
        ]);
    }

    public function update(OperationFamilyRequest $request, OperationFamily $family)
    {
        $family->update($request->all());
        return redirect()->route('admin.families.index')->with('success_message', 'Familia actualizada');
    }

    public function destroy(OperationFamily $family)
    {
        try {
            $family->delete();
        } catch (\Exception $e) {
            return back()->with('error_message', 'Esta familia está asociada a alguna operación.');
        }
        
        return back()->with('success_message', 'Familia eliminada');
    }
}
