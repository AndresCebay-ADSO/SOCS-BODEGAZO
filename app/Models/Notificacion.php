<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'idNot'; 
    
    protected $fillable = [
        'idUsuNot', 
        'menNot',
        'fechNot',
        'estNot'
    ];

    protected $casts = [
        'fechNot' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuNot', 'id');
    }
}