<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Preventive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPreventiveController extends Controller
{

    public function index(Request $request)
    {
        $preventives =  Auth::user()->customer->preventives()->latest();

        if ($request->completed) {
            $preventives = $preventives->whereNotNull('finished_at');
        } else {
            $preventives = $preventives->whereNull('finished_at');
        }

        return view('customer.preventives.index', [
            'preventives' => $preventives->get()
        ]);
    }

    public function show(Preventive $preventive)
    {
        return view('customer.preventives.show', [
            'preventive' => $preventive
        ]);
    }
}
