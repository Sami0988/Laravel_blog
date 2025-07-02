<?php

namespace App\Http\Middleware;


namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {

        
        if (auth()->check() && auth()->user()->role === 'Admin') {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden. Admins only.'], 403);
    }
}

