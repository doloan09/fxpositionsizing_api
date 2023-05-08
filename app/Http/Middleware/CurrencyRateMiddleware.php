<?php

namespace App\Http\Middleware;

use Closure;

class CurrencyRateMiddleware
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
        $apikey        = $request->input('apikey');
        if ($apikey !== env('API_KEY')) {
            return response()->json(['status' => 403]);
        }

        return $next($request);
    }
}
