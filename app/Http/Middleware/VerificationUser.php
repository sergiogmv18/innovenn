<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VerificationUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next):Response
    {
        // Verificar si hay una sesión activa
        if (!Session::has('user') || now()->greaterThan(Session::get('expires_at'))) {
            Session::forget('user'); 
            $data = [
                'route'=> route('login'),
                'message'=> 'Usuario no encontrado, Por favor inicie session',
            ];
            return redirect()->route('errorPage')->with($data);
            
        }
        return $next($request);
    }
}
