<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        Rol::firstOrCreate(['nivRol' => Rol::SUPERADMIN], [
            'tipRol' => 'Superadmin',
            'nivRol' => Rol::SUPERADMIN,
            'desRol' => 'Rol con todos los privilegios',
            'estRol' => 'Activo'
        ]);

        Rol::firstOrCreate(['nivRol' => Rol::ADMIN], [
            'tipRol' => 'Administrador',
            'nivRol' => Rol::ADMIN,
            'desRol' => 'Rol para administradores estándar',
            'estRol' => 'Activo'
        ]);

        Rol::firstOrCreate(['nivRol' => Rol::CLIENTE], [
            'tipRol' => 'Cliente',
            'nivRol' => Rol::CLIENTE,
            'desRol' => 'Rol para usuarios clientes',
            'estRol' => 'Activo'
        ]);
    }
}