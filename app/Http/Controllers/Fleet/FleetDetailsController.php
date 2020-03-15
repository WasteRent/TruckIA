<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FleetRequest;
use Illuminate\Support\Facades\Auth;

class FleetDetailsController extends Controller
{

    public function index()
    {
        return view('fleet.details', [
            'fleet' => Auth::user()->fleet
        ]);
    }

    public function update(FleetRequest $request)
    {
        Auth::user()->fleet->update($request->toArray());
        return back()->with('success_message', 'Datos actualizados');
    }
}
