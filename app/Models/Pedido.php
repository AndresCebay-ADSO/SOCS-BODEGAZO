<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'idPed';
    public $timestamps = false;

    protected $fillable = [
        'idUsuPed', 
        'idProPed', 
        'fecPed', 
        'prePed', 
        'estPed',
        'referenceCode',
        'signature',
        'payment_method',
        'payment_state',
        'transaction_id',
        'fecha_pago'
    ];

    protected $casts = [
        'fecPed' => 'datetime:Y-m-d H:i:s',
        'prePed' => 'decimal:2',
        'fecha_pago' => 'datetime:Y-m-d H:i:s'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuPed', 'id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProPed', 'idPro');
    }
    
    public function detalles()
    {
        return $this->hasMany(Detallesped::class, 'idPedDet', 'idPed');
    }
}