<?php

namespace App\Http\Controllers;

use App\Models\PagoNequi;
use App\Models\FacturaElectronica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NequiController extends Controller
{
    private $apiUrl;
    private $apiKey;
    private $clientId;
    private $clientSecret;

    public function __construct()
    {
        $this->apiUrl = config('nequi.api_url', 'https://api.nequi.com.co');
        $this->apiKey = config('nequi.api_key');
        $this->clientId = config('nequi.client_id');
        $this->clientSecret = config('nequi.client_secret');
    }

    public function index()
    {
        $pagos = PagoNequi::with(['usuario', 'factura'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.nequi.index', compact('pagos'));
    }

    public function crearPago(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_celular' => 'required|string|size:10',
            'monto' => 'required|numeric|min:1000',
            'id_factura' => 'nullable|exists:facturas_electronicas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Crear registro de pago
            $pago = PagoNequi::create([
                'id_usuario' => auth()->id(),
                'id_factura' => $request->id_factura,
                'numero_celular' => $request->numero_celular,
                'monto' => $request->monto,
                'transaction_id' => $this->generarTransactionId(),
                'reference_id' => $this->generarReferenceId(),
                'status' => 'PENDING',
                'fecha_expiracion' => now()->addMinutes(10),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Generar código de validación
            $codigoValidacion = $pago->generarCodigoValidacion();
            $pago->update(['codigo_validacion' => $codigoValidacion]);

            // Enviar solicitud a Nequi
            $response = $this->enviarSolicitudPago($pago);

            if ($response['success']) {
                $pago->guardarRespuestaAPI($request->all(), $response, 200);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Solicitud de pago enviada',
                    'data' => [
                        'transaction_id' => $pago->transaction_id,
                        'codigo_validacion' => $codigoValidacion,
                        'fecha_expiracion' => $pago->fecha_expiracion,
                    ]
                ]);
            } else {
                $pago->actualizarEstado('FAILED', $response['message']);
                $pago->guardarRespuestaAPI($request->all(), $response, 400);
                
                return response()->json([
                    'success' => false,
                    'message' => $response['message']
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Error al crear pago Nequi: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function validarPago(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|string',
            'codigo_validacion' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pago = PagoNequi::where('transaction_id', $request->transaction_id)
                ->where('codigo_validacion', $request->codigo_validacion)
                ->first();

            if (!$pago) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transacción no encontrada o código inválido'
                ], 404);
            }

            if ($pago->estaExpiradoPorTiempo()) {
                $pago->actualizarEstado('EXPIRED', 'Pago expirado por tiempo');
                
                return response()->json([
                    'success' => false,
                    'message' => 'El pago ha expirado'
                ], 400);
            }

            // Validar con Nequi
            $response = $this->validarPagoNequi($pago);

            if ($response['success']) {
                $pago->actualizarEstado('SUCCESS', 'Pago validado exitosamente');
                $pago->guardarRespuestaAPI($request->all(), $response, 200);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Pago validado exitosamente',
                    'data' => [
                        'transaction_id' => $pago->transaction_id,
                        'monto' => $pago->monto,
                        'fecha_pago' => $pago->fecha_pago,
                    ]
                ]);
            } else {
                $pago->actualizarEstado('FAILED', $response['message']);
                $pago->guardarRespuestaAPI($request->all(), $response, 400);
                
                return response()->json([
                    'success' => false,
                    'message' => $response['message']
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Error al validar pago Nequi: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function consultarEstado(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction ID requerido'
            ], 422);
        }

        try {
            $pago = PagoNequi::where('transaction_id', $request->transaction_id)->first();

            if (!$pago) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transacción no encontrada'
                ], 404);
            }

            // Consultar estado en Nequi
            $response = $this->consultarEstadoNequi($pago);

            if ($response['success']) {
                $pago->guardarRespuestaAPI($request->all(), $response, 200);
                
                return response()->json([
                    'success' => true,
                    'data' => [
                        'transaction_id' => $pago->transaction_id,
                        'status' => $pago->status,
                        'monto' => $pago->monto,
                        'numero_celular' => $pago->numero_celular,
                        'fecha_creacion' => $pago->created_at,
                        'fecha_pago' => $pago->fecha_pago,
                        'message' => $pago->message,
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $response['message']
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Error al consultar estado Nequi: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function webhook(Request $request)
    {
        try {
            Log::info('Webhook Nequi recibido:', $request->all());

            // Verificar firma del webhook (implementar según documentación de Nequi)
            if (!$this->verificarFirmaWebhook($request)) {
                Log::warning('Firma de webhook inválida');
                return response()->json(['error' => 'Firma inválida'], 400);
            }

            $transactionId = $request->input('transaction_id');
            $status = $request->input('status');
            $message = $request->input('message');

            $pago = PagoNequi::where('transaction_id', $transactionId)->first();

            if (!$pago) {
                Log::warning('Pago no encontrado para webhook:', ['transaction_id' => $transactionId]);
                return response()->json(['error' => 'Pago no encontrado'], 404);
            }

            // Actualizar estado del pago
            $pago->actualizarEstado($status, $message);
            $pago->guardarRespuestaAPI($request->all(), $request->all(), 200);

            Log::info('Webhook procesado exitosamente:', ['transaction_id' => $transactionId, 'status' => $status]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Error procesando webhook Nequi: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno'], 500);
        }
    }

    public function show(PagoNequi $pago)
    {
        $pago->load(['usuario', 'factura']);
        
        return view('admin.nequi.show', compact('pago'));
    }

    // Métodos privados para la API de Nequi
    private function enviarSolicitudPago($pago)
    {
        try {
            $payload = [
                'transaction_id' => $pago->transaction_id,
                'reference_id' => $pago->reference_id,
                'phone_number' => $pago->numero_celular,
                'amount' => $pago->monto,
                'currency' => $pago->moneda,
                'expiration_time' => $pago->fecha_expiracion->format('Y-m-d H:i:s'),
                'description' => 'Pago factura ' . ($pago->factura ? $pago->factura->numero_factura : 'N/A'),
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->obtenerToken(),
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/payments/request', $payload);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'data' => $data
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error en la API de Nequi: ' . $response->body()
                ];
            }

        } catch (\Exception $e) {
            Log::error('Error enviando solicitud a Nequi: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error de conexión con Nequi'
            ];
        }
    }

    private function validarPagoNequi($pago)
    {
        try {
            $payload = [
                'transaction_id' => $pago->transaction_id,
                'validation_code' => $pago->codigo_validacion,
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->obtenerToken(),
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/payments/validate', $payload);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'data' => $data
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error validando pago: ' . $response->body()
                ];
            }

        } catch (\Exception $e) {
            Log::error('Error validando pago en Nequi: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error de conexión con Nequi'
            ];
        }
    }

    private function consultarEstadoNequi($pago)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->obtenerToken(),
            ])->get($this->apiUrl . '/payments/' . $pago->transaction_id);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'data' => $data
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error consultando estado: ' . $response->body()
                ];
            }

        } catch (\Exception $e) {
            Log::error('Error consultando estado en Nequi: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error de conexión con Nequi'
            ];
        }
    }

    private function obtenerToken()
    {
        // Implementar obtención de token OAuth2 según documentación de Nequi
        // Por ahora retornamos un token simulado
        return 'simulated_token_' . time();
    }

    private function verificarFirmaWebhook($request)
    {
        // Implementar verificación de firma según documentación de Nequi
        // Por ahora retornamos true para desarrollo
        return true;
    }

    private function generarTransactionId()
    {
        return 'NEQUI_' . time() . '_' . strtoupper(uniqid());
    }

    private function generarReferenceId()
    {
        return 'REF_' . time() . '_' . strtoupper(uniqid());
    }
}
