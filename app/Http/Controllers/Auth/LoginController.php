<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function form()
    {
        return view('auth.form');
    }

    public function authenticate(LoginRequest $request)
    {
        if (Auth::attempt($request->only('username', 'password'))) {
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
            }
        }
        return back();
    }

    public function logout()
    {
        Auth::logout();
    }
}
