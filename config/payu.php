<?php

return [
    'api_key' => env('PAYU_API_KEY'),
    'api_login' => env('PAYU_API_LOGIN'),
    'merchant_id' => env('PAYU_MERCHANT_ID'),
    'account_id' => env('PAYU_ACCOUNT_ID'),
    'sandbox' => env('PAYU_SANDBOX', true),
    'api_url' => env('PAYU_API_URL', 'https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi'),
];
