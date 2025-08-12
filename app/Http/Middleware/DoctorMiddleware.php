<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('doctors')->user();
        if ($user) {
            return $next($request);
        }
        return redirect()->route('doctor.login');
    }
}
