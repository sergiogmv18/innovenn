<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class VerifyFormTokenOfTravel
{
    protected $except = [
        'registrar/new/viajero'  // Excluir esta ruta de la verificación CSRF
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Session::has('user')){
            return $next($request);
        }

        // Verificar si el token existe en caché
        if (Cache::has("form_token_register_travel{$request->token}")) {
            return $next($request);
        }

        // Si el usuario está autenticado, permitir el acceso
        if (Auth::check()) {
            return $next($request);
        }

        // Si no cumple ninguna de las condiciones, redirigir
        $data = [
            'route'=> route('login'),
            'message'=> 'Acceso denegado. URL expirada',
        ];
        return redirect()->route('errorPage')->with($data);
    }
}
