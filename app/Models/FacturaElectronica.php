<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FacturaElectronica extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'facturas_electronicas';

    protected $fillable = [
        'numero_factura',
        'prefijo',
        'resolucion_dian',
        'fecha_emision',
        'hora_emision',
        'fecha_vencimiento',
        'id_usuario',
        'tipo_documento_cliente',
        'numero_documento_cliente',
        'nombre_cliente',
        'direccion_cliente',
        'telefono_cliente',
        'email_cliente',
        'nit_empresa',
        'nombre_empresa',
        'direccion_empresa',
        'telefono_empresa',
        'email_empresa',
        'subtotal',
        'iva',
        'descuento',
        'total',
        'moneda',
        'estado',
        'cufe',
        'qr_code',
        'xml_content',
        'pdf_content',
        'metodo_pago',
        'estado_pago',
        'referencia_pago',
        'tipo_operacion',
        'tipo_documento',
        'ambiente',
        'version_ubl',
        'version_dian',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'hora_emision' => 'datetime:H:i:s',
        'fecha_vencimiento' => 'date',
        'subtotal' => 'decimal:2',
        'iva' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
        'fecha_expiracion' => 'datetime',
        'fecha_pago' => 'datetime',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleFacturaElectronica::class, 'id_factura');
    }

    public function pagosNequi()
    {
        return $this->hasMany(PagoNequi::class, 'id_factura');
    }

    // Métodos para generar información de la factura
    public function generarNumeroFactura()
    {
        $ultimaFactura = self::whereYear('fecha_emision', now()->year)
            ->orderBy('numero_factura', 'desc')
            ->first();

        $numero = $ultimaFactura ? (int)$ultimaFactura->numero_factura + 1 : 1;
        
        return str_pad($numero, 8, '0', STR_PAD_LEFT);
    }

    public function calcularTotales()
    {
        $subtotal = $this->detalles->sum('subtotal');
        $iva = $this->detalles->sum('valor_iva');
        $descuento = $this->detalles->sum('valor_descuento');
        $total = $subtotal + $iva - $descuento;

        $this->update([
            'subtotal' => $subtotal,
            'iva' => $iva,
            'descuento' => $descuento,
            'total' => $total,
        ]);
    }

    // Métodos para el estado de la factura
    public function estaPagada()
    {
        return $this->estado_pago === 'pagado';
    }

    public function estaEnviada()
    {
        return in_array($this->estado, ['enviada', 'aceptada']);
    }

    public function puedeAnular()
    {
        return in_array($this->estado, ['borrador', 'enviada']) && !$this->estaPagada();
    }

    // Métodos para DIAN
    public function generarCUFE()
    {
        // Generar CUFE según especificaciones DIAN
        $fecha = $this->fecha_emision->format('Ymd');
        $hora = $this->hora_emision->format('His');
        $nit = str_pad($this->nit_empresa, 10, '0', STR_PAD_LEFT);
        $numero = str_pad($this->numero_factura, 8, '0', STR_PAD_LEFT);
        $ambiente = $this->ambiente;
        $tipo = $this->tipo_documento;
        
        $cufe = $fecha . $hora . $nit . $numero . $ambiente . $tipo;
        
        // Agregar hash para completar el CUFE
        $cufe .= substr(md5($cufe), 0, 8);
        
        return $cufe;
    }

    // Scopes para consultas
    public function scopePendientes($query)
    {
        return $query->where('estado_pago', 'pendiente');
    }

    public function scopePagadas($query)
    {
        return $query->where('estado_pago', 'pagado');
    }

    public function scopePorFecha($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_emision', [$fechaInicio, $fechaFin]);
    }

    public function scopePorCliente($query, $idUsuario)
    {
        return $query->where('id_usuario', $idUsuario);
    }
}
