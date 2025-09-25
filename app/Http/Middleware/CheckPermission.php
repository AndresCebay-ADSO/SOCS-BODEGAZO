<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $view)
    {
        $user = Auth::user();
        
        if ($user && $user->allowed_views) {
            $allowedViews = json_decode($user->allowed_views, true);
            $currentModule = $this->getModuleFromRoute($request);
            
            if ($currentModule && isset($allowedViews[$currentModule])) {
                if (in_array($view, $allowedViews[$currentModule])) {
                    return $next($request);
                }
            }
        }
        
        abort(403, 'No tienes permiso para acceder a esta vista.');
    }
    
    protected function getModuleFromRoute($request)
    {
        $route = $request->route();
        $prefix = $route->getPrefix();
        
        if (strpos($prefix, 'admin/') === 0) {
            $path = str_replace('admin/', '', $route->uri());
            $parts = explode('/', $path);
            return $parts[0];
        }
        
        return null;
    }
}