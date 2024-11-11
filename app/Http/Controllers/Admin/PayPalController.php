<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PayPalService;
use Illuminate\Http\Request;

class PayPalController extends Controller
{
    protected $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    public function createOrder(Request $request)
    {
        $amount = $request->input('amount');
        $order = $this->paypalService->createOrder($amount);

        if ($order) {
            return response()->json(['orderID' => $order->result->id]);
        }

        return response()->json(['error' => 'Unable to create order'], 500);
    }

    public function captureOrder(Request $request)
    {
        $orderID = $request->input('orderID');
        $result = $this->paypalService->captureOrder($orderID);

        if ($result) {
            return response()->json(['status' => 'Order captured successfully']);
        }

        return response()->json(['error' => 'Order capture failed'], 500);
    }
}
