<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
                $schedule = collect(explode('-', $a))->map(function($s) {
                    return explode(':', $s)[0];
                })->toArray();

                if ($schedule[0] < $schedule[1]) {
                    //ej: 09:00 19:00
                    $date1 = Carbon::createFromFormat("H:i", "{$schedule[0]}:00");
                    $date2 = Carbon::createFromFormat("H:i", "{$schedule[1]}:00");
                } else {
                    //ej: 21:00 06:00
                    if (now()->hour >= $schedule[1] && now()->hour <= 23) {
                        //21:00 - 23:59
                        $date1 = Carbon::createFromFormat("H:i", "{$schedule[0]}:00");
                        $date2 = Carbon::createFromFormat("H:i", "{$schedule[1]}:00")->addDays(1);
                    } else {
                        //00:00 - 06:00
                        $date1 = Carbon::createFromFormat("H:i", "{$schedule[0]}:00")->subDays(1);
                        $date2 = Carbon::createFromFormat("H:i", "{$schedule[1]}:00");
                    }
                }

                if (now()->gte($date1) && now()->lte($date2)) {
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
