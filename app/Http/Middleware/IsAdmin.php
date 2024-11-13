<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        } 
        if(Auth::check() && !Auth::user()->is_admin) {
            return redirect()->route('test');
        }
    }
}