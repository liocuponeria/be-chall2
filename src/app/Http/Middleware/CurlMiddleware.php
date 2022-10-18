<?php

namespace App\Http\Middleware;

use Closure;

class CurlMiddleware
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
        $userAgent = strtolower($request->header('User-Agent'));
        $isCurlRequest = strstr($userAgent, 'curl');

        if ($isCurlRequest) {
            return response()->json(['error' => 'Access Denied.'], 403);
        }

        return $next($request);
    }
}
