<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PagoNequi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pagos_nequi';

    protected $fillable = [
        'id_factura',
        'id_usuario',
        'numero_celular',
        'monto',
        'moneda',
        'transaction_id',
        'reference_id',
        'status',
        'message',
        'api_response_id',
        'api_request',
        'api_response',
        'api_status_code',
        'codigo_validacion',
        'fecha_expiracion',
        'fecha_pago',
        'ip_address',
        'user_agent',
        'notas',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_expiracion' => 'datetime',
        'fecha_pago' => 'datetime',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function factura()
    {
        return $this->belongsTo(FacturaElectronica::class, 'id_factura');
    }

    // Métodos para el estado del pago
    public function estaPendiente()
    {
        return $this->status === 'PENDING';
    }

    public function estaPagado()
    {
        return $this->status === 'SUCCESS';
    }

    public function estaFallido()
    {
        return $this->status === 'FAILED';
    }

    public function estaExpirado()
    {
        return $this->status === 'EXPIRED';
    }

    public function estaExpiradoPorTiempo()
    {
        return $this->fecha_expiracion && now()->isAfter($this->fecha_expiracion);
    }

    // Métodos para generar información
    public function generarTransactionId()
    {
        return 'NEQUI_' . time() . '_' . strtoupper(uniqid());
    }

    public function generarReferenceId()
    {
        return 'REF_' . time() . '_' . strtoupper(uniqid());
    }

    public function generarCodigoValidacion()
    {
        return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    // Métodos para la API
    public function actualizarEstado($status, $message = null)
    {
        $this->update([
            'status' => $status,
            'message' => $message,
        ]);

        if ($status === 'SUCCESS') {
            $this->update(['fecha_pago' => now()]);
            
            // Actualizar estado de la factura si existe
            if ($this->factura) {
                $this->factura->update([
                    'estado_pago' => 'pagado',
                    'referencia_pago' => $this->transaction_id,
                ]);
            }
        }
    }

    public function guardarRespuestaAPI($request, $response, $statusCode)
    {
        $this->update([
            'api_request' => is_array($request) ? json_encode($request) : $request,
            'api_response' => is_array($response) ? json_encode($response) : $response,
            'api_status_code' => $statusCode,
        ]);
    }

    // Scopes para consultas
    public function scopePendientes($query)
    {
        return $query->where('status', 'PENDING');
    }

    public function scopeExitosos($query)
    {
        return $query->where('status', 'SUCCESS');
    }

    public function scopeFallidos($query)
    {
        return $query->where('status', 'FAILED');
    }

    public function scopePorUsuario($query, $idUsuario)
    {
        return $query->where('id_usuario', $idUsuario);
    }

    public function scopePorFactura($query, $idFactura)
    {
        return $query->where('id_factura', $idFactura);
    }

    public function scopePorCelular($query, $numeroCelular)
    {
        return $query->where('numero_celular', $numeroCelular);
    }
}
