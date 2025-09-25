<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Pedido;

class PayUController extends Controller
{
    public function createPayment(Request $request)
    {
        $request->validate([
            'pedido_id' => 'required|exists:pedidos,idPed',
            'valor' => 'required|numeric|min:1',
            'descripcion' => 'required|string',
            'email' => 'required|email',
            'telefono' => 'required|string',
            'metodo_pago' => 'required|string'
        ]);

        $pedido = Pedido::findOrFail($request->pedido_id);
        
        // Verificar que el pedido pertenece al usuario autenticado
        if ($pedido->idUsuPed != auth()->user()->id) {
            abort(403, 'No tienes permisos para pagar este pedido.');
        }
        
        // Verificar que el pedido esté en estado "Por pagar"
        if ($pedido->estPed !== 'Por pagar') {
            return back()->with('error', 'Este pedido no puede ser pagado en su estado actual.');
        }

        $referenceCode = "PEDIDO_" . $pedido->idPed . "_" . time();
        $signature = md5(config('payu.api_key') . "~" . config('payu.merchant_id') . "~" . $referenceCode . "~" . $pedido->prePed . "~COP");

        $response = Http::post(config('payu.api_url'), [
            "language" => "es",
            "command" => "SUBMIT_TRANSACTION",
            "merchant" => [
                "apiKey" => config('payu.api_key'),
                "apiLogin" => config('payu.api_login'),
            ],
            "transaction" => [
                "order" => [
                    "accountId" => config('payu.account_id'),
                    "referenceCode" => $referenceCode,
                    "description" => $request->descripcion,
                    "language" => "es",
                    "signature" => $signature,
                    "additionalValues" => [
                        "TX_VALUE" => ["value" => $pedido->prePed, "currency" => "COP"]
                    ],
                    "buyer" => [
                        "emailAddress" => $request->email
                    ]
                ],
                "payer" => [
                    "emailAddress" => $request->email
                ],
                "type" => "AUTHORIZATION_AND_CAPTURE",
                "paymentMethod" => "VISA",
                "paymentCountry" => "CO",
                "ipAddress" => $request->ip(),
            ],
            "test" => config('payu.sandbox'),
        ]);

        // Guardar información de la transacción en el pedido
        $pedido->update([
            'referenceCode' => $referenceCode,
            'signature' => $signature,
            'payment_method' => $request->metodo_pago
        ]);

        // Para propósitos de desarrollo, simular pago exitoso
        if (config('payu.sandbox', true)) {
            // Simular pago exitoso
            DB::beginTransaction();
            try {
                $pedido->update([
                    'estPed' => 'En camino',
                    'fecha_pago' => now(),
                    'transaction_id' => 'TEST_' . uniqid(),
                    'payment_state' => 'APPROVED'
                ]);
                
                DB::commit();
                
                
                return redirect()->route('clientes.pedidos.factura', $pedido->idPed)
                    ->with('success', '¡Pago realizado exitosamente! Tu pedido está siendo procesado.');
                    
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Error en PayUController: ' . $e->getMessage());
                return back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
            }
        }

        $responseData = $response->json();

        // Verificar si la respuesta fue exitosa
        if (isset($responseData['code']) && $responseData['code'] === 'SUCCESS') {
            // Si es exitosa, redirigir a la URL de pago de PayU
            if (isset($responseData['transactionResponse']['extraParameters']['URL_PAYMENT_RECEIPT_HTML'])) {
                return redirect($responseData['transactionResponse']['extraParameters']['URL_PAYMENT_RECEIPT_HTML']);
            }
            
            // Si no hay URL de pago, mostrar mensaje de éxito
            return redirect()->route('clientes.pedidos.index')
                ->with('success', 'Pago procesado exitosamente. Tu pedido está siendo procesado.');
        } else {
            // Si hay error, mostrar mensaje de error
            $errorMessage = $responseData['error'] ?? 'Error desconocido al procesar el pago.';
            return back()->with('error', 'Error al procesar el pago: ' . $errorMessage);
        }
    }

    public function paymentResponse(Request $request)
    {
        $request->validate([
            'referenceCode' => 'required|string',
            'transactionState' => 'required|string',
            'signature' => 'required|string'
        ]);

        // Buscar el pedido por referenceCode
        $pedido = Pedido::where('referenceCode', $request->referenceCode)->first();
        
        if (!$pedido) {
            return redirect()->route('clientes.pedidos.index')
                ->with('error', 'Pedido no encontrado.');
        }

        // Verificar que el pedido pertenece al usuario autenticado
        if ($pedido->idUsuPed != auth()->user()->id) {
            abort(403, 'No tienes permisos para acceder a este pedido.');
        }

        // Verificar la firma
        $expectedSignature = md5(config('payu.api_key') . "~" . config('payu.merchant_id') . "~" . $request->referenceCode . "~" . $pedido->prePed . "~COP");
        
        if ($request->signature !== $expectedSignature) {
            return redirect()->route('clientes.pedidos.index')
                ->with('error', 'Error en la verificación del pago.');
        }

        // Actualizar estado del pedido según la respuesta
        if ($request->transactionState === 'APPROVED') {
            DB::beginTransaction();
            try {
                $pedido->update([
                    'estPed' => 'En camino',
                    'fecha_pago' => now(),
                    'transaction_id' => $request->get('transactionId'),
                    'payment_state' => $request->transactionState
                ]);
                
                DB::commit();
                
                return redirect()->route('clientes.pedidos.factura', $pedido->idPed)
                    ->with('success', '¡Pago realizado exitosamente! Tu pedido está siendo procesado.');
                    
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('clientes.pedidos.index')
                    ->with('error', 'Error al procesar el pago: ' . $e->getMessage());
            }
        } else {
            // Pago rechazado o pendiente
            $pedido->update([
                'payment_state' => $request->transactionState,
                'fecha_pago' => now()
            ]);
            
            $message = match($request->transactionState) {
                'PENDING' => 'Tu pago está siendo procesado. Te notificaremos cuando esté confirmado.',
                'DECLINED' => 'Tu pago fue rechazado. Por favor, intenta con otro método de pago.',
                'EXPIRED' => 'El tiempo para realizar el pago ha expirado.',
                default => 'El estado del pago es: ' . $request->transactionState
            };
            
            return redirect()->route('clientes.pedidos.index')
                ->with('error', $message);
        }
    }

    public function paymentNotification(Request $request)
    {
        // Este método maneja las notificaciones automáticas de PayU
        // Por ahora solo retornamos un 200 OK
        return response()->json(['status' => 'OK'], 200);
    }
}
