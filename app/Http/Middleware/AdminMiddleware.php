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
        
        // Verificar si el usuario tiene rol de admin (1) o superadmin (3)
        if (!in_array($user->idRolUsu, [1, 3])) {
            abort(403, 'Acceso no autorizado para administradores');
        }

        return $next($request);
    }
}