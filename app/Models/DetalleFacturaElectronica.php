<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleFacturaElectronica extends Model
{
    use HasFactory;

    protected $table = 'detalles_factura_electronica';

    protected $fillable = [
        'id_factura',
        'id_producto',
        'codigo_producto',
        'nombre_producto',
        'descripcion',
        'unidad_medida',
        'cantidad',
        'precio_unitario',
        'subtotal',
        'porcentaje_iva',
        'valor_iva',
        'porcentaje_descuento',
        'valor_descuento',
        'total',
        'codigo_impuesto',
        'base_imponible',
        'tipo_impuesto',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'porcentaje_iva' => 'decimal:2',
        'valor_iva' => 'decimal:2',
        'porcentaje_descuento' => 'decimal:2',
        'valor_descuento' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // Relaciones
    public function factura()
    {
        return $this->belongsTo(FacturaElectronica::class, 'id_factura');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'idPro');
    }

    // Métodos para calcular totales
    public function calcularSubtotal()
    {
        return $this->cantidad * $this->precio_unitario;
    }

    public function calcularIVA()
    {
        return $this->subtotal * ($this->porcentaje_iva / 100);
    }

    public function calcularDescuento()
    {
        return $this->subtotal * ($this->porcentaje_descuento / 100);
    }

    public function calcularTotal()
    {
        return $this->subtotal + $this->valor_iva - $this->valor_descuento;
    }

    public function calcularTotales()
    {
        $this->subtotal = $this->calcularSubtotal();
        $this->valor_iva = $this->calcularIVA();
        $this->valor_descuento = $this->calcularDescuento();
        $this->total = $this->calcularTotal();
        
        $this->save();
    }
}
