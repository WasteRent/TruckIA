<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\AlertType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAlertController extends Controller
{

    public function index(Request $request)
    {
        $alerts = Alert::filter($request->all())
                        ->where('customer_id', Auth::user()->customer->id)
                        ->latest()
                        ->paginate(40);

        return view('customer.alerts.index', [
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
