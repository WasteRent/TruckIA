<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        switch (Auth::user()->role) {
            case 'admin':
                return redirect()->intended(route('admin.home'));
                break;
            case 'garage':
                return redirect()->intended(route('garage.home'));
                break;
            case 'fleet':
                return redirect()->intended(route('fleet.home'));
                break;
            case 'customer':
                return redirect()->intended(route('customer.home'));
                break;
        }
    }
}
