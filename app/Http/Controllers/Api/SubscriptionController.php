<?php

namespace App\Http\Controllers\Api;

use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function checkSubscription(Request $request)
    {
        $request->validate(['user_id' => 'required|integer']);

        $userId = (int) $request->input('user_id');
        $sub    = $this->subscriptionService->latestForUser($userId);
        $active = $this->subscriptionService->isActive($sub);

        return response()->json([
            'subscribed'           => $active,
            'subscription_status'  => $this->subscriptionService->statusString($sub),
            'subscription_ends_at' => $sub ? $sub->end_date : null,
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
