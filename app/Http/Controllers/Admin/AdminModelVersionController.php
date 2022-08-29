<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VersionRequest;
use App\Models\Model;
use App\Models\Version;

class AdminModelVersionController extends Controller
{
    public function index(Model $model)
    {
        return view('admin.manufacturers.models.versions.index', [
            'manufacturer' => $model->manufacturer,
            'model' => $model,
            'versions' => $model->versions()->orderBy('name')->get(),
        ]);
    }

    public function create(Model $model)
    {
        return view('admin.manufacturers.models.versions.create', [
            'manufacturer' => $model->manufacturer,
            'model' => $model
        ]);
    }

    public function store(VersionRequest $request, Model $model)
    {
        $version = new Version($request->all());
        $version->model_id = $model->id;
        $version->save();

        return redirect()->route('admin.models.versions.index', $model)
            ->with('success_message', 'Den. com. creada');
    }

    public function edit(Model $model, Version $version)
    {
        return view('admin.manufacturers.models.versions.edit', [
            'manufacturer' => $model->manufacturer,
            'model' => $model,
            'version' => $version
        ]);
    }

    public function update(VersionRequest $request, Model $model, Version $version)
    {
        $version->update($request->all());

        return redirect()->route('admin.models.versions.index', $model)
            ->with('success_message', 'Den. com. actualizada');
    }

    public function destroy(Model $model, Version $version)
    {
        try {
            $version->delete();
        } catch (\Exception $e) {
            return back()->with('error_message', 'Este den. com. está asociado a vehículos o planes de mantenimiento.');
        }

        return back()->with('success_message', 'Den. com. eliminada');
    }
}
