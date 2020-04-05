<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\ModelRequest;
use App\Models\Manufacturer;
use App\Models\Model;

class FleetManufacturerModelController extends Controller
{

    public function index(Manufacturer $manufacturer)
    {
        return view('fleet.manufacturers.models.index', [
            'manufacturer' => $manufacturer,
            'models' => $manufacturer->models()->orderBy('name')->get()
        ]);
    }

    public function create(Manufacturer $manufacturer)
    {
        return view('fleet.manufacturers.models.create', ['manufacturer' => $manufacturer]);
    }

    public function store(ModelRequest $request, Manufacturer $manufacturer)
    {
        $model = new Model($request->all());
        $model->manufacturer_id = $manufacturer->id;
        $model->save();
        return redirect()->route('fleet.manufacturers.models.index', $manufacturer)
            ->with('success_message', 'Modelo creado');
    }

    public function edit(Manufacturer $manufacturer, Model $model)
    {
        return view('fleet.manufacturers.models.edit', [
            'manufacturer' => $manufacturer,
            'model' => $model
        ]);
    }

    public function update(ModelRequest $request, Manufacturer $manufacturer, Model $model)
    {
        $model->update($request->all());
        return redirect()->route('fleet.manufacturers.models.index', $manufacturer)
            ->with('success_message', 'Modelo actualizado');
    }

    public function destroy(Manufacturer $manufacturer, Model $model)
    {
        try {
            $model->delete();
        } catch (\Exception $e) {
            return back()->with('error_message', 'Este modelo está asociado a vehículos o planes de mantenimiento.');
        }
        
        return back()->with('success_message', 'Modelo eliminado');
    }
}
