<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Package;
use App\Models\Payment;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = Subscription::with(['user', 'package', 'payment'])->latest()->get();

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

        // Create payment record
        $payment = Payment::create([
            'user_id'        => $request->user_id,
            'package_id'     => $request->package_id,
            'amount'         => $request->pay_amount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
        ]);

        /** @var SubscriptionService $svc */
        $svc = app(SubscriptionService::class);
        ['renewed' => $renewed] = $svc->createOrRenew(
            userId:    (int) $request->user_id,
            packageId: (int) $request->package_id,
            paymentId: $payment->id,
            startDate: Carbon::parse($request->start_date),
            endDate:   Carbon::parse($request->end_date),
            status:    $status,
        );

        $message = $renewed ? 'Subscription renewed successfully.' : 'Subscription created successfully.';

        return redirect()->route('admin.subscription.index')->with('success', $message);
    }
}
