<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManufacturerRequest;
use App\Models\Manufacturer;

class AdminManufacturerController extends Controller
{

    public function index()
    {
        return view('admin.manufacturers.index', [
            'manufacturers' => Manufacturer::all()
        ]);
    }

    public function create()
    {
        return view('admin.manufacturers.create');
    }

    public function store(ManufacturerRequest $request)
    {
        $manufacturer = new Manufacturer($request->all());
        $manufacturer->save();
        return redirect()->route('admin.manufacturers.index')->with('success_message', 'Fabricante creado');
    }

    public function edit(Manufacturer $manufacturer)
    {
        return view('admin.manufacturers.edit', [
            'manufacturer' => $manufacturer
        ]);
    }

    public function update(ManufacturerRequest $request, Manufacturer $manufacturer)
    {
        $manufacturer->update($request->all());
        return redirect()->route('admin.manufacturers.index')->with('success_message', 'Fabricante actualizado');
    }

    public function destroy(Manufacturer $manufacturer)
    {
        try {
            $manufacturer->delete();
        } catch (\Exception $e) {
            return back()->with('error_message', 'Esta marca está asociada a vehículos o planes de mantenimiento.');
        }
        
        return back()->with('success_message', 'Fabricante eliminado');
    }
}
