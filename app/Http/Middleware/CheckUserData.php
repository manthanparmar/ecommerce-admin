<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckUserData
{
    public function handle($request, Closure $next)
    {
        if (Session::has('userSession') && !empty(Session::has('userSession'))) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Unauthorized access');
    }
}
