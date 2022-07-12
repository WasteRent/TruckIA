<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\ManufacturerRequest;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class FleetManufacturerController extends Controller
{
    public function index(Request $request)
    {
        $manufacturers = Manufacturer::query();

        if ($request->category) {
            $manufacturers->whereHas('models', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        return view('fleet.manufacturers.index', [
            'manufacturers' => $manufacturers->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('fleet.manufacturers.create');
    }

    public function store(ManufacturerRequest $request)
    {
        $manufacturer = new Manufacturer($request->all());
        $manufacturer->save();

        return redirect()->route('fleet.manufacturers.index')->with('success_message', 'Fabricante creado');
    }

    public function edit(Manufacturer $manufacturer)
    {
        return view('fleet.manufacturers.edit', [
            'manufacturer' => $manufacturer,
        ]);
    }

    public function update(ManufacturerRequest $request, Manufacturer $manufacturer)
    {
        $manufacturer->update($request->all());

        return redirect()->route('fleet.manufacturers.index')->with('success_message', 'Fabricante actualizado');
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
