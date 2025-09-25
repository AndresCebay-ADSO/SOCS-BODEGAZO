<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Detallesped extends Model 
{
    protected $table = 'detallesped';
    protected $primaryKey = 'idDet';
    public $timestamps = false;
    
    protected $fillable = [
        'canDet',
        'preProDet',
        'idPedDet',
        'idProDet'
    ];
    
    // Relación con Pedido
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'idPedDet', 'idPed');
    }

    // Relación con Producto
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'idProDet', 'idPro');
    }

}