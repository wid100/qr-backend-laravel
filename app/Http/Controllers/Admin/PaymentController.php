<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'transaction_id' => 'required|string',
        ]);

        // Create Payment
        $payment = Payment::create($validatedData);

        return response()->json($payment, 201);
    }


    public function index()
    {
        $payment = Payment::all();
        return view('admin.payment.index', compact('payment'));
    }
}
