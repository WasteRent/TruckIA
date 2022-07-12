<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class TrixController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $folder = App::environment('production') ? 'trucki' : 'ec21';

            $filename = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filenametostore = $filename.'_'.time().'.'.$extension;

            $request->file('file')->storeAs("{$folder}/trix", $filenametostore);
            Storage::setVisibility("{$folder}/trix/{$filenametostore}", 'public');
            $url = Storage::url("{$folder}/trix/{$filenametostore}");

            if (config('filesystems.default') == 'spaces') {
                $url = str_replace('.digitaloceanspaces.com', '.cdn.digitaloceanspaces.com', $url);
            }

            return $url;
        }
    }
}
