<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Debugging - Verifica los valores
        \Log::info('Verificación de rol', [
            'user_id' => Auth::id(),
            'current_role' => Auth::user()->idRolUsu,
            'required_role' => $role
        ]);

        if ((int)Auth::user()->idRolUsu != (int)$role) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}