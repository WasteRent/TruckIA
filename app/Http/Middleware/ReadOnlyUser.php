<?php

namespace App\Http\Middleware;

use Closure;

class ReadOnlyUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user() && auth()->user()->is_readonly && !$request->isMethod('get') && $request->path() != "logout") {
            abort(403);
        }

        return $next($request);
    }
}
