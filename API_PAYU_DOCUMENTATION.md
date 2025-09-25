# Documentación API PayU - SOCS Project

## Información General

Esta documentación describe la implementación de la API de PayU en el proyecto SOCS. La integración permite procesar pagos electrónicos a través de la plataforma PayU Latam.

## Configuración

### Variables de Entorno

```env
PAYU_API_KEY=tu_api_key
PAYU_API_LOGIN=tu_api_login
PAYU_MERCHANT_ID=tu_merchant_id
PAYU_ACCOUNT_ID=tu_account_id
PAYU_SANDBOX=true
PAYU_API_URL=https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi
```

### Archivo de Configuración

El archivo `config/payu.php` contiene la configuración de la API:

```php
return [
    'api_key' => env('PAYU_API_KEY'),
    'api_login' => env('PAYU_API_LOGIN'),
    'merchant_id' => env('PAYU_MERCHANT_ID'),
    'account_id' => env('PAYU_ACCOUNT_ID'),
    'sandbox' => env('PAYU_SANDBOX', true),
    'api_url' => env('PAYU_API_URL', 'https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi'),
];
```

## Endpoints de la API

### 1. Crear Pago

**Endpoint:** `POST /cliente/pagos/crear`

**Descripción:** Crea una nueva transacción de pago a través de PayU.

**Headers:**
```
Content-Type: application/json
Authorization: Bearer {token}
```

**Parámetros de Entrada:**
```json
{
    "monto": 100.00,
    "descripcion": "Pago de productos SOCS",
    "email_comprador": "cliente@ejemplo.com",
    "metodo_pago": "VISA",
    "referencia_pedido": "PED_123456"
}
```

**Respuesta Exitosa:**
```json
{
    "code": "SUCCESS",
    "error": null,
    "transactionResponse": {
        "orderId": "12345678",
        "transactionId": "abc123def456",
        "state": "PENDING",
        "paymentNetworkResponseCode": null,
        "paymentNetworkResponseErrorMessage": null,
        "trazabilityCode": "TRAZ123456",
        "authorizationCode": null,
        "pendingReason": "PENDING_TRANSACTION_CONFIRMATION",
        "responseCode": "PENDING_TRANSACTION_CONFIRMATION",
        "errorCode": null,
        "responseMessage": "La transacción está pendiente de confirmación"
    }
}
```

**Respuesta de Error:**
```json
{
    "code": "ERROR",
    "error": "Error en la transacción",
    "transactionResponse": null
}
```

### 2. Respuesta de Pago

**Endpoint:** `POST /cliente/pagos/respuesta`

**Descripción:** Maneja la respuesta de PayU después del procesamiento del pago.

**Parámetros de Entrada:**
```json
{
    "transactionState": "4",
    "polTransactionId": "abc123def456",
    "polOrderId": "12345678",
    "polAmount": 100.00,
    "polCurrency": "COP",
    "polPaymentMethod": "VISA",
    "polPaymentMethodType": "CREDIT_CARD",
    "polPaymentMethodName": "VISA",
    "polResponseCode": "1",
    "polResponseMessage": "APPROVED"
}
```

### 3. Notificación de Pago

**Endpoint:** `POST /cliente/pagos/notificacion`

**Descripción:** Webhook para recibir notificaciones automáticas de PayU sobre el estado de las transacciones.

## Estructura de Datos

### PayUController

El controlador principal maneja las siguientes operaciones:

1. **createPayment()**: Crea una nueva transacción
2. **paymentResponse()**: Procesa la respuesta del pago
3. **paymentNotification()**: Maneja notificaciones webhook

### Payload de Transacción

```json
{
    "language": "es",
    "command": "SUBMIT_TRANSACTION",
    "merchant": {
        "apiKey": "tu_api_key",
        "apiLogin": "tu_api_login"
    },
    "transaction": {
        "order": {
            "accountId": "tu_account_id",
            "referenceCode": "REF_123456",
            "description": "Pago de productos SOCS",
            "language": "es",
            "signature": "firma_md5",
            "additionalValues": {
                "TX_VALUE": {
                    "value": 100.00,
                    "currency": "COP"
                }
            },
            "buyer": {
                "emailAddress": "cliente@ejemplo.com"
            }
        },
        "payer": {
            "emailAddress": "cliente@ejemplo.com"
        },
        "type": "AUTHORIZATION_AND_CAPTURE",
        "paymentMethod": "VISA",
        "paymentCountry": "CO",
        "ipAddress": "192.168.1.1"
    },
    "test": true
}
```

## Estados de Transacción

| Código | Estado | Descripción |
|--------|--------|-------------|
| 1 | APPROVED | Transacción aprobada |
| 2 | DECLINED | Transacción declinada |
| 3 | EXPIRED | Transacción expirada |
| 4 | PENDING | Transacción pendiente |

## Códigos de Respuesta

| Código | Descripción |
|--------|-------------|
| SUCCESS | Operación exitosa |
| ERROR | Error en la operación |
| PENDING_TRANSACTION_CONFIRMATION | Transacción pendiente de confirmación |

## Seguridad

### Firma de Transacción

La firma se genera usando MD5 con la siguiente estructura:
```
md5(apiKey~merchantId~referenceCode~amount~currency)
```

### Validaciones

- Validación de IP del cliente
- Verificación de firma de transacción
- Validación de montos mínimos
- Verificación de datos del comprador

## Flujo de Pago

1. **Cliente inicia pago** → `POST /cliente/pagos/crear`
2. **PayU procesa** → Redirige a formulario de pago
3. **Cliente completa pago** → PayU procesa la transacción
4. **PayU responde** → `POST /cliente/pagos/respuesta`
5. **Notificación automática** → `POST /cliente/pagos/notificacion`

## Manejo de Errores

### Errores Comunes

- **400 Bad Request**: Datos de entrada inválidos
- **401 Unauthorized**: Credenciales de API incorrectas
- **422 Unprocessable Entity**: Error de validación
- **500 Internal Server Error**: Error interno del servidor

### Logs

Los errores se registran en:
- `storage/logs/laravel.log`
- Logs específicos de PayU en el controlador

## Testing

### Modo Sandbox

Para pruebas, asegúrate de que `PAYU_SANDBOX=true` en tu archivo `.env`.

### Datos de Prueba

```json
{
    "numero_tarjeta": "4005580000000002",
    "cvv": "123",
    "fecha_vencimiento": "12/25",
    "nombre_titular": "Test User"
}
```

## Consideraciones de Producción

1. **Cambiar a modo producción**: `PAYU_SANDBOX=false`
2. **Usar URLs de producción**: Actualizar `PAYU_API_URL`
3. **Configurar webhooks**: Asegurar que las notificaciones lleguen correctamente
4. **Monitoreo**: Implementar logs detallados para transacciones
5. **Backup**: Respaldo regular de transacciones importantes

## Soporte

Para soporte técnico o consultas sobre la implementación de PayU, contacta al equipo de desarrollo de SOCS.
