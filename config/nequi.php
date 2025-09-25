<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración de Nequi API
    |--------------------------------------------------------------------------
    |
    | Configuración para la integración con la API de Nequi
    |
    */

    // Configuración de la API
    'api_url' => env('NEQUI_API_URL', 'https://api.nequi.com.co'),
    'api_key' => env('NEQUI_API_KEY'),
    'client_id' => env('NEQUI_CLIENT_ID'),
    'client_secret' => env('NEQUI_CLIENT_SECRET'),

    // Configuración de autenticación
    'grant_type' => env('NEQUI_GRANT_TYPE', 'client_credentials'),
    'scope' => env('NEQUI_SCOPE', 'payments'),

    // Configuración de pagos
    'monto_minimo' => env('NEQUI_MONTO_MINIMO', 1000),
    'monto_maximo' => env('NEQUI_MONTO_MAXIMO', 1000000),
    'tiempo_expiracion' => env('NEQUI_TIEMPO_EXPIRACION', 10), // minutos

    // Configuración de webhooks
    'webhook_secret' => env('NEQUI_WEBHOOK_SECRET'),
    'webhook_url' => env('NEQUI_WEBHOOK_URL', '/api/nequi/webhook'),

    // Configuración de reintentos
    'max_reintentos' => env('NEQUI_MAX_REINTENTOS', 3),
    'tiempo_reintento' => env('NEQUI_TIEMPO_REINTENTO', 30), // segundos

    // Configuración de logs
    'log_requests' => env('NEQUI_LOG_REQUESTS', true),
    'log_responses' => env('NEQUI_LOG_RESPONSES', true),

    // Configuración de ambiente
    'ambiente' => env('NEQUI_AMBIENTE', 'sandbox'), // sandbox, production

    // Configuración de notificaciones
    'enviar_notificaciones' => env('NEQUI_ENVIAR_NOTIFICACIONES', true),
    'email_notificaciones' => env('NEQUI_EMAIL_NOTIFICACIONES', 'admin@elbodegazo.com'),

    // Configuración de validaciones
    'validar_celular' => env('NEQUI_VALIDAR_CELULAR', true),
    'formato_celular' => env('NEQUI_FORMATO_CELULAR', '/^3[0-9]{9}$/'),

    // Configuración de moneda
    'moneda' => env('NEQUI_MONEDA', 'COP'),
    'decimales' => env('NEQUI_DECIMALES', 2),

    // Configuración de descripción
    'descripcion_default' => env('NEQUI_DESCRIPCION_DEFAULT', 'Pago El Bodegazo'),
]; 