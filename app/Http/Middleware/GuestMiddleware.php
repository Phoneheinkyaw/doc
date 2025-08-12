<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class GuestMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            return back();
        }
        return $next($request);
    }
}
