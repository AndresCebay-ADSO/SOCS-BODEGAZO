<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nomUsu',
        'apeUsu',
        'dirUsu',
        'telUsu',
        'TipdocUsu',
        'numdocUsu',
        'emaUsu',
        'passUsu',
        'idRolUsu',
        'estadoUsu',
    ];

    protected $hidden = [
        'passUsu',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'passUsu' => 'hashed', // Laravel 12 usa 'password' como campo por defecto, pero aquí es 'passUsu'
    ];

    public function getAuthIdentifierName()
    {
        return 'emaUsu';
    }

    public function getAuthPassword()
    {
        return $this->passUsu;
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'idUsuPed', 'id');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'idUsuNot', 'id');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idRolUsu', 'idRol');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission', 'user_id', 'permission_id')
                    ->withTimestamps();
    }

    public function isAdmin()
    {
        return optional($this->rol)->tipRol === 'admin';
    }

    public function isCliente()
    {
        return optional($this->rol)->tipRol === 'cliente';
    }

    public function hasPermissionTo($permissionName)
    {
        // Chequea permisos directos del usuario
        if ($this->permissions()->where('name', $permissionName)->exists()) {
            return true;
        }
        // Fallback a permisos del rol
        return $this->rol ? $this->rol->hasPermissionTo($permissionName) : false;
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nomUsu . ' ' . $this->apeUsu;
    }
}