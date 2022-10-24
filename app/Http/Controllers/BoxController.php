<?php

namespace App\Http\Controllers;

use App\Models\RepairOrder;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoxController extends Controller
{
    public function auth(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'username'  => 'required',
                'password'  => 'required',
                'qrid'      => 'required'
            ]);

            if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
                $request->session()->regenerate();

                $vehicle = Vehicle::where('qrid', $data['qrid'])->firstOrFail();

                return redirect()->route('box.show', $vehicle);
            }
     
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);

        } else {
            $vehicle = null;
            if ($request->qrid) {
                $vehicle = Vehicle::where('qrid', $request->qrid)->first();
            }
        
            return view('box.auth', ['vehicle' => $vehicle]);
        }
    }

    public function preview(Request $request)
    {
        if ($request->qrid) {
            $vehicle = Vehicle::where('qrid', $request->qrid)->first();
        }

        return view('box.preview', [
            'vehicle' => $vehicle ?? null,
        ]);
    }

    public function show(Vehicle $vehicle)
    {
        return view('box.show', [
            'vehicle' => $vehicle,
        ]);
    }
}
