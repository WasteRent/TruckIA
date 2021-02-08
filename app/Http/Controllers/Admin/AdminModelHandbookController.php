<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Model;
use Illuminate\Http\Request;

class AdminModelHandbookController extends Controller
{

    public function index(Model $model)
    {
        return view('admin.manufacturers.models.handbooks.index', [
            'manufacturer' => $model->manufacturer,
            'model' => $model
        ]);
    }

    public function storeTechnical(Request $request, Model $model)
    {
        $request->validate(['file' => 'required|file']);

        $file = File::storeFile($request->file, 'Manual');

        $model->update(['technical_handbook_file_id' => $file->id]);

        return back()->with('success_message', 'Manual cargado');
    }

    public function destroyTechnical(Model $model)
    {
        $file = $model->technicalHandbook;

        $model->update(['technical_handbook_file_id' => null]);

        $file->removeFile();
        $file->delete();

        return back()->with('success_message', 'Manual eliminado');
    }

    public function storeUsage(Request $request, Model $model)
    {
        $request->validate(['file' => 'required|file']);

        $file = File::storeFile($request->file, 'Manual');

        $model->update(['usage_handbook_file_id' => $file->id]);

        return back()->with('success_message', 'Manual cargado');
    }

    public function destroyUsage(Model $model)
    {
        $file = $model->usageHandbook;

        $model->update(['usage_handbook_file_id' => null]);

        $file->removeFile();
        $file->delete();
        
        return back()->with('success_message', 'Manual eliminado');
    }
}
