<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EnsureLoggedIn
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('user')) {
            return redirect()->route('travelersRegisterHome', Session::get('user')->uuid);
        }
        return $next($request);
    }
}