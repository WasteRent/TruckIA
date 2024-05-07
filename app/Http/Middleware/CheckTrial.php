<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTrial
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && ! Auth::user()->trial_ends_at) {
            return $next($request);
        } elseif (Auth::user() && Auth::user()->trial_ends_at && Carbon::parse(Auth::user()->trial_ends_at)->diffInDays() > 0) {
            return $next($request);
        } else {
            Auth::logout();

            return redirect('/login')->with('error_message', 'El periodo de prueba ha finalizado');
        }
    }
}
