<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripePaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|max:3',
        ]);

        $amount = (int)($request->input('amount') * 100);
        $currency = $request->input('currency', 'usd');
        $customerName = $request->input('customer_name', 'Customer Name');
        $customerEmail = $request->input('customer_email', 'customer@example.com');

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'payment_method_types' => ['card'],
                'metadata' => [
                    'customer_name' => $customerName,
                    'customer_email' => $customerEmail,
                ],
                'receipt_email' => $customerEmail,
            ]);

            return response()->json(['clientSecret' => $paymentIntent->client_secret]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function store(Request $request)
    {
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


        $maxRetries = 3;
        $attempts = 0;

        while ($attempts < $maxRetries) {
            try {
                DB::beginTransaction();

                // Create payment
                $payment = $this->createPayment($request);
                // Create subscription
                $this->createSubscription($request, $payment->id);
                // Create order
                $this->createOrder($request, $payment->id);
                Log::info('Payment record created successfully', ['payment' => $payment]);

                DB::commit();
                return response()->json(['message' => 'Transaction saved successfully.', 'data' => $payment], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                $attempts++;
                Log::error("Transaction attempt $attempts failed: " . $e->getMessage());

                if ($attempts < $maxRetries) {
                    sleep(1);
                }
            }
        }

        // If all attempts failed
        return response()->json(['error' => 'Failed to save transaction after multiple attempts', 'details' => 'Please try again later.'], 500);
    }

    private function createPayment($request)
    {
        return Payment::create([
            'user_id' => $request->input('user_id'),
            'package_id' => $request->input('package_id'),
            'amount' => $request->input('amount'),
            'transaction_id' => $request->input('transaction_id'),
            'payment_method' => 'stripe',
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
            'payment_method' => 'stripe',
            'status' => true,
        ]);
    }
}