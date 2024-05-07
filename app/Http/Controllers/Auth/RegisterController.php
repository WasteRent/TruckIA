<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'fleet' => 'required',
            'vehicles' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
            'privacy_check' => 'required',
        ]);

        $fleet = Fleet::create([
            'name' => $data['fleet'],
            'notifications_email' => $data['email'],
            'crane_opening_hours' => $data['vehicles'],
        ]);

        $user = User::create([
            'name' => $data['firstname'].' '.$data['lastname'],
            'username' => $data['email'],
            'password' => bcrypt($data['password']),
            'email' => $data['email'],
            'is_active' => 1,
            'is_readonly' => 0,
            'role' => 'fleet',
            'job' => 'fleet_manager',
            'trial_ends_at' => now()->addDays(16),
            'entity_relation_id' => $fleet->id,
        ]);

        Auth::loginUsingId($user->id);

        return redirect('/fleet/vehicles');
    }
}
