<?php

namespace App\Http\Controllers\Api;

use App\Models\Qrgen;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function checkSubscription(Request $request)
    {
        $userId = $request->input('user_id');

        // Check if the user has data in the Qrgen table
        $haveCard = Qrgen::where('user_id', $userId)->exists();

        // If the user doesn't have data in the Qrgen table, return true
        if (!$haveCard) {
            return response()->json(['subscribed' => true]);
        }

        // If the user has data in the Qrgen table, check the subscription table
        $subscription = Subscription::where('user_id', $userId)->first();

        // If the user is subscribed or has an end date greater than the current date, return true
        if ($subscription && ($subscription->end_date > now() || $subscription->status == 1)) {
            return response()->json(['subscribed' => true]);
        } else {
            return response()->json(['subscribed' => false]);
        }
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
