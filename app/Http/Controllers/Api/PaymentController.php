<?php


namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Payment; // Import the Payment model
use App\Models\Subscription; // Import the Subscription model

class PaymentController extends Controller
{





    public function makePayment(Request $request)
    {
        // Generate a unique transaction ID
        $tran_id = "smartcardgenerator" . rand(1111111, 9999999);

        // Define payment details
        $currency = "BDT";
        $store_id = "smartcardgenerator";
        $signature_key = "4e9f074f4232a743e899bde462e750d9";

        $url = "https://secure.aamarpay.com/jsonpost.php";

        $response = \Illuminate\Support\Facades\Http::post($url, [
            'store_id' => $store_id,
            'tran_id' => $tran_id,
            'success_url' => route('success'),
            // 'success_url' => env('FRONTEND_URL'),
            'fail_url' => route('fail'),
            'cancel_url' => route('cancel'),
            'amount' => $request->input('amount'),
            'currency' => $currency,
            'signature_key' => $signature_key,
            'desc' => "Merchant Registration Payment",
            'cus_name' => $request->input('name'),
            'cus_email' => $request->input('email'),
            'cus_add1' => $request->input('address'),
            'cus_add2' => $request->input('district'),
            'cus_city' => $request->input('city'),
            'cus_state' => $request->input('city'),
            'cus_postcode' => $request->input('1207'),
            'cus_country' => $request->input('country'),
            'cus_phone' => $request->input('phone'),
            'type' => "json",
            'opt_a' => $request->input('user_id'),
            'opt_b' => $request->input('package_id'),
            'opt_c' => $request->input('end_date'),
        ]);

        $responseData = $response->json();

        if (isset($responseData['payment_url']) && !empty($responseData['payment_url'])) {
            return response()->json(['payment_url' => $responseData['payment_url']]);
        } else {
            return response()->json(['error' => 'Failed to generate payment URL'], 400);
        }
    }

    public function success(Request $request)
    {
        $requestId = $request->mer_txnid;

        // Verify the transaction using Search Transaction API
        $requestIdEncoded = urlencode($requestId);
        $url = "http://secure.aamarpay.com/api/v1/trxcheck/request.php?request_id=$requestIdEncoded&store_id=smartcardgenerator&signature_key=4e9f074f4232a743e899bde462e750d9&type=json";

        $responsedd = Http::get($url);
        $responseDatadd = $responsedd->json();

        $responseData = $request->all();

        // Initialize payment data array
        $paymentData = [
            'user_id' => $responseData['opt_a'] ?? null,
            'transaction_id' => $responseData['bank_txn'] ?? null,
            'amount' => $responseData['amount'] ?? null,
            'cus_name' => $responseData['cus_name'] ?? null,
            'payment_method' => $responseData['card_type'] ?? null,
            'package_id' => $responseData['opt_b'] ?? null,
            'cus_phone' => $responseData['cus_phone'] ?? null,
            'cus_email' => $responseData['cus_email'] ?? null,
            'country' => $responseDatadd['cus_country'] ?? null,
            'cus_add1' => $responseDatadd['cus_add1'] ?? null,
            'cus_postcode' => $responseDatadd['cus_postcode'] ?? null,
            'cus_add2' => $responseDatadd['cus_add2'] ?? null,
            'status' => $responseData['pay_status'] ?? null,
        ];

        // Check if the end date key exists in the response data
        $endDate = isset($responseData['opt_c']) ? Carbon::now()->addMonths((int)$responseData['opt_c']) : null;

        // Create a new Payment instance and save it to the database
        $payment = new Payment();
        $payment->user_id = $paymentData['user_id'];
        $payment->transaction_id = $paymentData['transaction_id'];
        $payment->amount = $paymentData['amount'];
        $payment->payment_method = $paymentData['payment_method'];
        $payment->package_id = $paymentData['package_id'];
        $payment->save();
        $paymentId = $payment->id;

        // Create a new Subscription instance and save it to the database
        $subscription = new Subscription();
        $subscription->user_id = $paymentData['user_id'];
        $subscription->payment_id = $paymentId;
        $subscription->package_id = $paymentData['package_id'];
        $subscription->start_date = Carbon::now();
        $subscription->end_date = $endDate;
        $subscription->status = true;
        $subscription->save();

        // Create a new Order instance and save it to the database
        $order = new Order();
        $order->user_id = $paymentData['user_id'];
        $order->payment_id = $paymentId;
        $order->package_id = $paymentData['package_id'];
        $order->phone = $paymentData['cus_phone'];
        $order->name = $paymentData['cus_phone'];
        $order->email = $paymentData['cus_name'];
        $order->country = $paymentData['country'];
        $order->address = $paymentData['cus_add1'];
        $order->zip = $paymentData['cus_postcode'];
        $order->district = $paymentData['cus_add2'];
        $order->amount = $paymentData['amount'];
        $order->payment_method = $paymentData['payment_method'];
        $order->status = true;
        $order->save();

        // Close the current window
        echo "<script>window.close();</script>";

        // Redirect the parent window to the dashboard URL
        echo "<script>window.opener.location.href = 'https://smartcardgenerator.net/dashboard';</script>";
    }









    public function fail(Request $request)
    {
        return $request;
    }

    public function cancel()
    {
        return 'Canceled';
    }




    public function verifyPayment(Request $request)
    {
        // Handle verification logic here
    }
}
