<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\SmartCard;
use App\Models\CardOrder;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use App\Mail\AdminNewOrderNotification;
use Illuminate\Support\Facades\Mail;

class SmartCardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getCardDetails($id)

    {
        $card = SmartCard::find($id);

        if (!$card) {
            return response()->json(['message' => 'Card not found'], 404);
        }


        return response()->json($card);
    }

    public function createCheckoutSession(Request $request)
    {

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $request->currency ?? 'usd',
                    'product_data' => [
                        'name' => $request->product_name ?? 'Smart Card',
                    ],
                    'unit_amount' => $request->amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/payment-success'),
            'cancel_url' => url('/payment-cancel'),
        ]);

        return response()->json(['id' => $session->id]);
    }




    public function createPaymentIntent(Request $request)
    {

        $amount = $request->amount * 100;

        $intent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => $request->currency ?? 'usd',
            'metadata' => [
                'user_id' => $request->user_id,
                'product_id' => $request->smart_card_id
            ],
        ]);

        return response()->json(['clientSecret' => $intent->client_secret]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'qrgen_id' => 'required|exists:qrgens,id',
            'smart_card_id' => 'required|exists:smart_cards,id',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:20',
            'quantity' => 'nullable|integer|min:1',
            'payment_method' => 'nullable',
            'transaction_id' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $order = new CardOrder();
        $order->user_id = $request->user_id;
        $order->qrgen_id = $request->qrgen_id;
        $order->smart_card_id = $request->smart_card_id;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->country = $request->country;
        $order->town = $request->district;
        $order->address = $request->address;
        $order->city = $request->city;
        $order->zip = $request->zip;
        $order->payment_method = $request->payment_method ?? 'stripe';
        $order->tracking_number = $request->transaction_id;

        $order->order_number = 'ORD-' . strtoupper(uniqid());
        $order->quantity = $request->quantity ?? 1;
        $order->total_price = $request->amount;
        $order->status = 'pending';
        // $order->currency = $request->currency ?? 'BDT';

        $order->save();

        // 🔔 Send email to admin
        Mail::to('womenindigitalbd@gmail.com')->send(new AdminNewOrderNotification($order));
        return response()->json(['message' => 'Order created successfully'], 201);
    }





    public function __invoke(Request $request)
    {
        $cards = SmartCard::where('status', 0)->get()->map(function ($card) {
            $card->font_image = url('storage/' . $card->font_image);
            $card->back_image = url('storage/' . $card->back_image);
            $card->status = $card->status === 0 ? 'active' : 'inactive';
            return $card;
        })->makeHidden(['created_at', 'updated_at']);

        return response()->json($cards);
    }
}
