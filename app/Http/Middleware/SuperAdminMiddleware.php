<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Verifica el rol usando idRolUsu (3 para superadmin según la base de datos)
        if (Auth::user()->idRolUsu != 3) {
            abort(403, 'No tienes permiso para acceder a esta área');
        }

        return $next($request);
    }
}