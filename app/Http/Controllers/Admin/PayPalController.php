<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    private $client;
    private $baseUrl;
    private $clientId;
    private $secret;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = config('app.env') === 'production' ? 'https://api.paypal.com' : 'https://api.sandbox.paypal.com';
        $this->clientId = env('PAYPAL_CLIENT_ID');
        $this->secret = env('PAYPAL_SECRET');
    }

    // Step 4: Create PayPal Order
    public function createPayment(Request $request)
    {
        $amountValue = $request->input('amount');
        $currency = $request->input('currency', 'usd');
        try {
            $response = $this->client->post("{$this->baseUrl}/v2/checkout/orders", [
                'auth' => [$this->clientId, $this->secret],
                'json' => [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'amount' => [
                                'currency_code' => $currency,
                                'value' => $amountValue,
                            ]
                        ]
                    ]
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Step 5: Capture Payment
    public function captureOrder(Request $request)
    {
        $orderId = $request->input('orderID');

        $request->validate([
            'user_id' => 'required|integer',
            'package_id' => 'required|integer',
            'amount' => 'required|numeric',
            'transaction_id' => 'required|string',
            'end_date' => 'required|integer|min:1',
            // Add validations for the order fields
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'country' => 'required|string',
            'address' => 'required|string',
            'zip' => 'required|string',
            'district' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Create payment
            $payment = $this->storePayment($request);
            // Create subscription
            $this->createSubscription($request, $payment->id);
            // Create order
            $this->createOrder($request, $payment->id);
            Log::info('Payment record created successfully', ['payment' => $payment]);
            DB::commit();

            $response = $this->client->post("{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture", [
                'auth' => [$this->clientId, $this->secret],
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Transaction failed: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    private function storePayment($request)
    {
        return Payment::create([
            'user_id' => $request->input('user_id'),
            'package_id' => $request->input('package_id'),
            'amount' => $request->input('amount'),
            'transaction_id' => $request->input('transaction_id'),
            'payment_method' => 'Paypal',
        ]);
    }

    private function createSubscription($request, $paymentId)
    {
        return Subscription::create([
            'user_id' => $request->input('user_id'),
            'payment_id' => $paymentId,
            'package_id' => $request->input('package_id'),
            'start_date' => now(),
            'end_date' => now()->addMonths($request->input('end_date')),
            'status' => true,
        ]);
    }

    private function createOrder($request, $paymentId)
    {
        return Order::create([
            'user_id' => $request->input('user_id'),
            'payment_id' => $paymentId,
            'package_id' => $request->input('package_id'),
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'country' => $request->input('country'),
            'address' => $request->input('address'),
            'zip' => $request->input('zip'),
            'amount' => $request->input('amount'),
            'district' => $request->input('district'),
            'payment_method' => 'Paypal',
            'status' => true,
        ]);
    }
}
