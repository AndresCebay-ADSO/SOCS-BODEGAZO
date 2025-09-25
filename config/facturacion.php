<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración de Facturación Electrónica
    |--------------------------------------------------------------------------
    |
    | Configuración para la facturación electrónica según especificaciones DIAN
    |
    */

    // Información de la empresa
    'nit_empresa' => env('FACTURACION_NIT_EMPRESA', '900000000-1'),
    'nombre_empresa' => env('FACTURACION_NOMBRE_EMPRESA', 'El Bodegazo SAS'),
    'direccion_empresa' => env('FACTURACION_DIRECCION_EMPRESA', 'Calle 123 # 45-67'),
    'telefono_empresa' => env('FACTURACION_TELEFONO_EMPRESA', '3001234567'),
    'email_empresa' => env('FACTURACION_EMAIL_EMPRESA', 'info@elbodegazo.com'),
    'resolucion_dian' => env('FACTURACION_RESOLUCION_DIAN', 'DIAN-123456789'),

    // Configuración DIAN
    'ambiente' => env('FACTURACION_AMBIENTE', '1'), // 1: Pruebas, 2: Producción
    'version_ubl' => env('FACTURACION_VERSION_UBL', '2.1'),
    'version_dian' => env('FACTURACION_VERSION_DIAN', '2.1'),
    'tipo_operacion' => env('FACTURACION_TIPO_OPERACION', '10'), // 10: Estándar, 09: AIU
    'tipo_documento' => env('FACTURACION_TIPO_DOCUMENTO', '01'), // 01: Factura

    // Configuración de impuestos
    'porcentaje_iva' => env('FACTURACION_PORCENTAJE_IVA', 19.00),
    'moneda' => env('FACTURACION_MONEDA', 'COP'),

    // Configuración de numeración
    'prefijo_factura' => env('FACTURACION_PREFIJO', 'FAC'),
    'longitud_numero' => env('FACTURACION_LONGITUD_NUMERO', 8),

    // Configuración de archivos
    'ruta_xml' => env('FACTURACION_RUTA_XML', 'storage/facturas/xml'),
    'ruta_pdf' => env('FACTURACION_RUTA_PDF', 'storage/facturas/pdf'),
    'ruta_qr' => env('FACTURACION_RUTA_QR', 'storage/facturas/qr'),

    // Configuración de API DIAN (si aplica)
    'dian_api_url' => env('DIAN_API_URL', 'https://api.dian.gov.co'),
    'dian_api_key' => env('DIAN_API_KEY'),
    'dian_api_secret' => env('DIAN_API_SECRET'),

    // Configuración de notificaciones
    'enviar_email' => env('FACTURACION_ENVIAR_EMAIL', true),
    'email_template' => env('FACTURACION_EMAIL_TEMPLATE', 'emails.factura'),

    // Configuración de validaciones
    'validar_rues' => env('FACTURACION_VALIDAR_RUES', true),
    'validar_ruc' => env('FACTURACION_VALIDAR_RUC', true),
    'validar_contribuyente' => env('FACTURACION_VALIDAR_CONTRIBUYENTE', true),
]; 