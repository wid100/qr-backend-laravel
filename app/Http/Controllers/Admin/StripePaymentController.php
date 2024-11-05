<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripePaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Validate the incoming request
        $request->validate([
            'amount' => 'required|numeric|min:1',
            // 'currency' => 'required|string|max:3',
        ]);

        // Get the amount and currency from the request
        $amount = (int)($request->input('amount') * 100);
        $currency = 'usd';
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


    // save data
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'package_id' => 'required|integer',
            'amount' => 'required|numeric',
            'transaction_id' => 'required|string',
            'end_date' => 'required|integer|min:1',
        ]);


        $data = [
            'user_id' => $request->input('user_id'),
            'package_id' => $request->input('package_id'),
            'amount' => $request->input('amount'),
            'transaction_id' => $request->input('transaction_id'),
            'payment_method' => 'stripe',
        ];
        $payment = Payment::create($data);
        $paymentId = $payment->id;

        // make subscription
        $subscription = Subscription::create([
            'user_id' => $request->input('user_id'),
            'payment_id' => $paymentId,
            'package_id' => $request->input('package_id'),
            'start_date' => now(),
            'end_date' => now()->addMonths($request->input('end_date')),
            'status' => true,
        ]);




        return response()->json(['message' => 'Transaction saved successfully.', 'data' => $payment], 200);
    }
}
