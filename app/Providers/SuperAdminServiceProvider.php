<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Usuario;
use App\Models\Producto;

class SuperAdminServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Solo aplicar si existen las vistas de superadmin
        View::composer('superadmin.*', function ($view) {
            try {
                $view->with([
                    'globalSettings' => [
                        'max_users' => 100,
                        'backup_enabled' => true
                    ],
                    'systemStats' => [
                        'total_users' => Usuario::count(),
                        'active_products' => Producto::where('estPro', 3)->count() 
                    ]
                ]);
            } catch (\Exception $e) {
                // Si hay error con la BD, usar valores por defecto
                $view->with([
                    'globalSettings' => [
                        'max_users' => 100,
                        'backup_enabled' => true
                    ],
                    'systemStats' => [
                        'total_users' => 0,
                        'active_products' => 0
                    ]
                ]);
            }
        });
    }
}