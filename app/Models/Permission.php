<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'module', 'action', 'allowed_views'];
    
    protected $dates = ['deleted_at'];
    
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'permission_role', 'permission_id', 'role_id')
                    ->withTimestamps();
    }
    
    public function users()
    {
        return $this->belongsToMany(Usuario::class, 'user_permission', 'permission_id', 'user_id')
                    ->withTimestamps();
    }
    
    public static function createBasePermissions()
    {
        $modules = [
            'facturacion' => [
                'name' => 'Facturación', 
                'views' => ['index', 'create', 'edit', 'show', 'enviar-dian', 'descargar-pdf', 'descargar-xml', 'anular']
            ],
            'inventarios' => [
                'name' => 'Inventarios', 
                'views' => ['index', 'create', 'edit', 'show', 'reporte', 'exportar']
            ],
            'pedidos' => [
                'name' => 'Pedidos', 
                'views' => ['index', 'create', 'edit', 'show', 'factura', 'updateEstado']
            ],
            'usuarios' => [
                'name' => 'Usuarios', 
                'views' => ['index', 'create', 'edit', 'show', 'historial', 'buscar', 'factura']
            ],
            'roles' => [
                'name' => 'Roles', 
                'views' => ['index', 'create', 'edit']
            ],
            'permisos' => [
                'name' => 'Permisos', 
                'views' => ['index', 'edit']
            ],
            'productos' => [
                'name' => 'Productos', 
                'views' => ['index', 'create', 'edit', 'show']
            ],
            'notificaciones' => [
                'name' => 'Notificaciones', 
                'views' => ['index', 'create', 'edit']
            ],
        ];
        
        $actions = [
            'view' => 'Ver',
            'create' => 'Crear',
            'edit' => 'Editar',
            'delete' => 'Eliminar'
        ];
        
        $created = 0;
        
        foreach ($modules as $module => $moduleData) {
            foreach ($actions as $action => $actionName) {
                $permission = Permission::firstOrCreate(
                    [
                        'name' => "$module.$action",
                        'module' => $module,
                        'action' => $action
                    ],
                    [
                        'description' => "$actionName {$moduleData['name']}",
                        'allowed_views' => json_encode($moduleData['views'])
                    ]
                );
                
                if ($permission->wasRecentlyCreated) {
                    $created++;
                }
            }
        }
        
        return $created;
    }
    
    public static function getByModule()
    {
        return self::all()->groupBy('module');
    }
    
    public function getAllowedViewsAttribute()
    {
        return json_decode($this->attributes['allowed_views'], true) ?? [];
    }
}