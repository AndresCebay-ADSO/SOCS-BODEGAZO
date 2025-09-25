<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroActividad extends Model
{
    protected $table = 'registro_actividades';
    
    protected $fillable = [
        'idUsu',
        'accion',
        'modelo',
        'modelo_id',
        'detalles',
        'ip',
        'user_agent',
        'created_at'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsu', 'id');
    }
    
    public static function logActivity($accion, $modelo = null, $modeloId = null, $detalles = null)
    {
        self::create([
            'idUsu' => auth()->id(),
            'accion' => $accion,
            'modelo' => $modelo,
            'modelo_id' => $modeloId,
            'detalles' => $detalles,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }
}