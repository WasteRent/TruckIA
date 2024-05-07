<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FleetContainerPictureController extends Controller
{
    public function index(Container $container)
    {
        return view('fleet.containers.pictures.index', [
            'container' => $container,
        ]);
    }

    public function update(Request $request, Container $container, int $file_id)
    {
        if ($request->cover) {
            $file = File::findOrFail($file_id);

            foreach ($container->pictures as $picture) {
                $container->pictures()->updateExistingPivot($picture->id, ['cover' => 0]);
            }

            $container->pictures()->updateExistingPivot($file->id, ['cover' => 1]);
        }

        return back()->with('success_message', 'Portada actualizada');
    }

    public function store(Request $request, Container $container)
    {
        $request->validate(['file' => 'required|image']);
        $file = File::storeFile($request->file, 'Foto');

        $container->pictures()->attach($file);

        return back()->with('success_message', 'Foto añadida');
    }

    public function destroy(Container $container, int $file_id)
    {
        $file = File::findOrFail($file_id);
        Storage::delete($file->getPath());
        $container->pictures()->detach($file);
        $file->delete();

        return back()->with('success_message', 'Foto eliminada');
    }
}
