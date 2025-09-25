<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::createBasePermissions();
        
        // Asignar todos los permisos al superadmin
        $superadmin = \App\Models\Rol::where('tipRol', 'Superadmin')->first();
        if ($superadmin) {
            $superadmin->permissions()->sync(Permission::pluck('id'));
        }
    }
}