<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\CustomerRequest;
use App\Models\EnterpriseGroup;
use Illuminate\Support\Facades\Auth;

class CustomerDetailsController extends Controller
{

    public function index()
    {
        return view('customer.details', [
            'customer' => Auth::user()->customer,
            'enterprises' => EnterpriseGroup::all()
        ]);
    }

    public function update(CustomerRequest $request)
    {
        Auth::user()->customer->update($request->toArray());
        return back()->with('success_message', 'Datos actualizados');
    }
}
