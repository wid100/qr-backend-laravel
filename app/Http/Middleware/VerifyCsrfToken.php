<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * Note: Sanctum's EnsureFrontendRequestsAreStateful handles CSRF for stateful
     * SPA requests via the X-XSRF-TOKEN header. Only third-party webhooks
     * (e.g. payment providers) should be added here.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/success',
        'api/fail',
        'api/cancel',
        'api/paypal/*',
        'api/save-transaction',
        'api/create-payment-intent',
        'api/create-checkout-session',
        'api/verify-payment',
        'api/make-payment',
        'api/check-subscription',
    ];
}
