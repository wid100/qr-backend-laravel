<?php


namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{





    public function makePayment(Request $request)
    {
        $tran_id = "test" . rand(1111111, 9999999);
        $currency = "BDT";
        $amount = $request->input('amount');
        $store_id = "aamarpaytest";
        $signature_key = "dbb74894e82415a2f7ff0ec3a97e4183";

        $url = "https://sandbox.aamarpay.com/jsonpost.php";

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
        ])->post($url, [
            'store_id' => $store_id,
            'tran_id' => $tran_id,
            'success_url' => route('success'),
            'fail_url' => route('fail'),
            'cancel_url' => route('cancel'),
            'amount' => $amount,
            'currency' => $currency,
            'signature_key' => $signature_key,
            'desc' => "Merchant Registration Payment",
            'cus_name' => "Name",
            'cus_email' => "payer@merchantcusomter.com",
            'cus_add1' => "House B-158 Road 22",
            'cus_add2' => "Mohakhali DOHS",
            'cus_city' => "Dhaka",
            'cus_state' => "Dhaka",
            'cus_postcode' => "1206",
            'cus_country' => "Bangladesh",
            'cus_phone' => "+88017928921",
            'type' => "json"
        ]);

        $responseData = $response->json();

        if (isset($responseData['payment_url']) && !empty($responseData['payment_url'])) {
            return redirect()->away($responseData['payment_url']);
        } else {
            return $response->body();
        }
    }



    // public function makePayment(Request $request)
    // {
    //     $client = new Client();

    //     $response = $client->post('https://sandbox.aamarpay.com/jsonpost.php', [
    //         'form_params' => [
    //             'store_id' => 'aamarpaytest',
    //             'signature_key' => 'dbb74894e82415a2f7ff0ec3a97e4183',
    //             'amount' => $request->input('amount'),
    //             'currency' => 'BDT', // Change to your currency code
    //             // Add other required parameters as per aamarPay documentation
    //             // e.g., tran_id, success_url, fail_url, etc.
    //         ]
    //     ]);

    //     return $response->getBody();
    // }




    // public function makePayment()
    // {

    //     $tran_id = "test" . rand(1111111, 9999999); //unique transection id for every transection

    //     $currency = "BDT"; //aamarPay support Two type of currency USD & BDT

    //     $amount = "10";   //10 taka is the minimum amount for show card option in aamarPay payment gateway

    //     //For live Store Id & Signature Key please mail to support@aamarpay.com
    //     $store_id = "aamarpaytest";

    //     $signature_key = "dbb74894e82415a2f7ff0ec3a97e4183";

    //     $url = "https://​sandbox​.aamarpay.com/jsonpost.php"; // for Live Transection use "https://secure.aamarpay.com/jsonpost.php"

    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => '{
    //         "store_id": "' . $store_id . '",
    //         "tran_id": "' . $tran_id . '",
    //         "success_url": "' . route('success') . '",
    //         "fail_url": "' . route('fail') . '",
    //         "cancel_url": "' . route('cancel') . '",
    //         "amount": "' . $amount . '",
    //         "currency": "' . $currency . '",
    //         "signature_key": "' . $signature_key . '",
    //         "desc": "Merchant Registration Payment",
    //         "cus_name": "Name",
    //         "cus_email": "payer@merchantcusomter.com",
    //         "cus_add1": "House B-158 Road 22",
    //         "cus_add2": "Mohakhali DOHS",
    //         "cus_city": "Dhaka",
    //         "cus_state": "Dhaka",
    //         "cus_postcode": "1206",
    //         "cus_country": "Bangladesh",
    //         "cus_phone": "+8801704",
    //         "type": "json"
    //     }',
    //         CURLOPT_HTTPHEADER => array(
    //             'Content-Type: application/json'
    //         ),
    //     ));

    //     $response = curl_exec($curl);

    //     curl_close($curl);
    //     // dd($response);

    //     $responseObj = json_decode($response);

    //     if (isset($responseObj->payment_url) && !empty($responseObj->payment_url)) {

    //         $paymentUrl = $responseObj->payment_url;
    //         // dd($paymentUrl);
    //         return redirect()->away($paymentUrl);
    //     } else {
    //         echo $response;
    //     }
    // }




    public function success(Request $request)
    {

        $request_id = $request->mer_txnid;

        //verify the transection using Search Transection API

        $url = "http://sandbox.aamarpay.com/api/v1/trxcheck/request.php?request_id=$request_id&store_id=aamarpaytest&signature_key=dbb74894e82415a2f7ff0ec3a97e4183&type=json";

        //For Live Transection Use "http://secure.aamarpay.com/api/v1/trxcheck/request.php"

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
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
