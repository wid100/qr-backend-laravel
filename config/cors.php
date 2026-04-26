<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie', '*'],

    'allowed_methods' => ['*'],

    // 'allowed_origins' => [env('FRONTEND_URL','https://smart-health-card-rho.vercel.app', 'http://localhost:3000', 'https://sandbox.aamarpay.com')],
    // 'allowed_origins' => explode(',', env('FRONTEND_URL', 'https://smart-health-card-rho.vercel.app')),

    // 'allowed_origins' => [
    //     'https://smartcardgenerator.net',
    //     'https://smart-health-card-rho.vercel.app',
    //     'http://localhost:3000',
    //     'https://sandbox.aamarpay.com'
    // ],
    'allowed_origins' => array_values(array_filter(array_map(function ($origin) {
        $origin = trim((string) $origin);
        $origin = rtrim($origin, '/');
        return $origin === '' ? null : $origin;
    }, explode(',', env('FRONTEND_URL', 'https://smart-health-card-rho.vercel.app,http://localhost:3000'))))),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
