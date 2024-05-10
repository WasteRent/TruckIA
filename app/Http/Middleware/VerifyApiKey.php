<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = 'H4=&98/><ZrD';

        if ($request->query('key') !== $apiKey) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
