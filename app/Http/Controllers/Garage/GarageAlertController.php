<?php

namespace App\Http\Controllers\Garage;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\AlertType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GarageAlertController extends Controller
{

    public function index(Request $request)
    {
        $alerts = Alert::filter($request->all())
                        ->where('garage_id', Auth::user()->garage->id)
                        ->latest()
                        ->paginate(40);

        return view('garage.alerts.index', [
            'alerts' => $alerts,
            'types' => AlertType::all()
        ]);
    }

    public function update(Request $request, Alert $alert)
    {
        $alert->update($request->all());
        return back()->with('success_message', 'Alerta actualizada');
    }
}
