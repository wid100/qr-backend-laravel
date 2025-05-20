<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscription::latest()->get();

        return view('admin.subscription.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $packages = Package::all();
        return view('admin.subscription.create', compact('users', 'packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'pay_amount' => 'required|numeric|min:0',
            'transaction_id' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'status' => 'nullable|in:active',
        ]);

        // Determine status
        $status = $request->has('status') ? 'active' : 'inactive';

        // Create payment
        $payment = Payment::create([
            'user_id' => $request->user_id,
            'package_id' => $request->package_id,
            'amount' => $request->pay_amount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
        ]);

        // Create subscription
        Subscription::create([
            'user_id' => $request->user_id,
            'package_id' => $request->package_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'payment_id' => $payment->id,
            'status' => $status,
        ]);

        return redirect()->route('admin.subscription.index')->with('success', 'Subscription created successfully.');
    }
}
