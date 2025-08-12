<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // Redirect to login if not authenticated
            return redirect()->route('login')->withErrors('Please log in first.');
        }

        // Allow request to proceed if authenticated
        return $next($request);
    }
}
