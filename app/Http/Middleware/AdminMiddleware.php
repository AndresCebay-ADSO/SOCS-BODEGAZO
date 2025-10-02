<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Verificar si el rol del usuario es admin (1) o superadmin (0) a través de la relación
        if (!in_array(optional($user->rol)->nivRol, [0, 1])) {
            abort(403, 'Acceso no autorizado para administradores');
        }

        return $next($request);
    }
}