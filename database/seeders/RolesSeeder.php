<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        Rol::updateOrCreate(['idRol' => 1], [
            'tipRol' => 'Superadmin',
            'nivRol' => Rol::SUPERADMIN,
            'desRol' => 'Rol con todos los privilegios',
            'estRol' => 'Activo'
        ]);

        Rol::updateOrCreate(['idRol' => 2], [
            'tipRol' => 'Administrador',
            'nivRol' => Rol::ADMIN,
            'desRol' => 'Rol para administradores estándar',
            'estRol' => 'Activo'
        ]);

        Rol::updateOrCreate(['idRol' => 3], [
            'tipRol' => 'Cliente',
            'nivRol' => Rol::CLIENTE,
            'desRol' => 'Rol para usuarios clientes',
            'estRol' => 'Activo'
        ]);
    }
}