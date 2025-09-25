<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $table = 'productos';
    protected $primaryKey = 'idPro';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'nomPro',
        'marPro',
        'codPro',
        'colPro',
        'tallPro',
        'idcatPro',
        'estPro',
        'unidad_medida',
        'precio_compra',
        'precio_venta',
        'descripcion',
        'imagen',
        'activo'
    ];
    
    protected $dates = ['deleted_at'];
    /*
        obtener la clave primaria del producto
    */ 
    public function getRouteKeyName()
    {
        return 'idPro';
    }
    /**
     * Relación con categoría
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idcatPro', 'idCat');
    }
    
    /**
     * Relación con inventarios
     */
    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'idProInv', 'idPro');
    }
    
    /**
     * URL completa de la imagen
     */
    public function getImagenUrlAttribute()
    {
        if ($this->imagen && \Storage::disk('public')->exists('productos/'.$this->imagen)) {
            return asset('storage/productos/'.$this->imagen);
        }
        return asset('images/default-product.png');
    }
}