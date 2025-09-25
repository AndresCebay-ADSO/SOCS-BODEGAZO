<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    const SUPERADMIN = 0;
    const ADMIN = 1;
    const CLIENTE = 2;

    protected $table = 'roles';
    protected $primaryKey = 'idRol';

    protected $fillable = [
        'tipRol', 'nivRol', 'desRol', 'estRol'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'idRolUsu', 'idRol');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id')
                    ->withTimestamps();
    }

    public function isSuperAdmin()
    {
        return $this->nivRol === self::SUPERADMIN;
    }

    public function isAdmin()
    {
        return $this->nivRol === self::ADMIN;
    }

    public function isCliente()
    {
        return $this->nivRol === self::CLIENTE;
    }

    public function hasPermissionTo($permissionName)
    {
        return $this->permissions()->where('name', $permissionName)->exists();
    }
    
    public function givePermissionTo($permissionName)
    {
        $permission = Permission::where('name', $permissionName)->firstOrFail();
        $this->permissions()->syncWithoutDetaching($permission);
    }
}