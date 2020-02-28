<?php

namespace mradang\LaravelWechat\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $guard = 'wechat';

        if (Auth::guard($guard)->guest()) {
            abort(401);
        }

        return $next($request);
    }
}
