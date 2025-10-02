<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Verificar si el usuario está autenticado y si su rol tiene el nivel de superadmin (0)
        if (Auth::check() && optional(Auth::user()->rol)->nivRol == 0) {
            return $next($request);
        }

        // Si no es Super Administrador, redirige o muestra un error
        abort(403, 'Acceso no autorizado');
    }
}