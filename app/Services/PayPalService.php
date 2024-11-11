<?php

namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;


class PayPalService

{
    private $client;

    public function __construct()
    {
        $environment = config('services.paypal.mode') === 'sandbox'
            ? new SandboxEnvironment(config('services.paypal.client_id'), config('services.paypal.secret'))
            : new ProductionEnvironment(config('services.paypal.client_id'), config('services.paypal.secret'));

        $this->client = new PayPalHttpClient($environment);
    }

    public function createOrder($amount)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount
                    ]
                ]
            ]
        ];

        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (\Exception $ex) {
            // Handle the exception
            return null;
        }
    }

    public function captureOrder($orderId)
    {
        $request = new OrdersCaptureRequest($orderId);

        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (\Exception $ex) {
            // Handle the exception
            return null;
        }
    }
}
