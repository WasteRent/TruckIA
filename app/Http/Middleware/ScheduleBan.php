<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleBan
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
        try {
            if ($request->user()->allowed_schedule) {
                $schedule = collect(explode('-', $request->user()->allowed_schedule))->map(function($s) {
                    return explode(':', $s)[0];
                })->toArray();

                if ($schedule[1] < $schedule[0] && (now()->hour >= $schedule[0] && now()->hour <= 24) && (now()->hour >= 0 && now()->hour <= $schedule[1])) {
                    return $next($request);
                }
                else if (now()->hour >= $schedule[0] && now()->hour <= $schedule[1]) {
                    return $next($request);
                }

                Auth::logout();
                return redirect('login')->with('error_message', 'Fuera de horario');
            }
        } catch (\Exception $e) {

        }

        return $next($request);
    }
}
