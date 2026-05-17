<?php

namespace App\Http\Controllers;

use App\Models\Admin\SmartCard;
use App\Models\CardOrder;
use App\Models\QrVisitorContact;
use App\Models\Qrgen;
use App\Services\SubscriptionService;
use App\Services\VisitorService;
use App\Support\SocialLinksHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class QrgenController extends Controller
{
    public function getPauseeQr($userId)
    {
        $pauseQr = Qrgen::where('user_id', $userId)
            ->where('status', 'paused')
            ->get();

        return response()->json(['pauseQr' => $pauseQr]);
    }


    public function getActiveQr($userId)
    {
        $activeQr = Qrgen::where('user_id', $userId)
            ->where('status', 'active')
            ->get();

        return response()->json(['activeQr' => $activeQr]);
    }
    /**
     * Display a listing of the resource.
     */

    public function toggleStatus($id)
    {
        $qrgen = Qrgen::find($id);

        if (!$qrgen) {
            return response()->json(['error' => 'Qrgen not found'], 404);
        }

        // Toggle the status
        $qrgen->status = $qrgen->status === 'active' ? 'paused' : 'active';
        $qrgen->save();

        $message = $qrgen->status === 'active' ? 'Qrgen activated successfully' : 'Qrgen paused successfully';

        return response()->json(['message' => $message]);
    }
    /**
     * Show the form for creating a new resource.
     */

    public function getGetqrByUser(User $user)
    {
        $getqr = Qrgen::with(['visitors', 'visitorContacts'])->where('user_id', $user->id)->get();

        return response()->json(['getqr' => $getqr]);
    }

    /**
     * Visitor shares their own contact (name / phone / note) after saving the card owner's vCard.
     */
    public function shareVisitorContact(Request $request, string $slug)
    {
        $showpost = Qrgen::where('slug', $slug)->first();
        if (!$showpost) {
            return response()->json(['message' => 'Card not found'], 404);
        }

        if ($showpost->status === 'paused') {
            return response()->json(['message' => 'This card is not accepting shares right now.'], 403);
        }

        /** @var SubscriptionService $svc */
        $svc = app(SubscriptionService::class);
        $sub = $svc->latestForUser((int) $showpost->user_id);
        if (!$svc->isActive($sub)) {
            return response()->json([
                'message' => 'This card is currently unavailable.',
                'code' => 'SUBSCRIPTION_EXPIRED',
            ], 403);
        }

        $validated = $request->validate([
            'visitor_name' => 'required|string|max:255',
            'visitor_phone' => 'required|string|max:64',
            'note' => 'nullable|string|max:2000',
        ]);

        QrVisitorContact::create([
            'qrgen_id' => $showpost->id,
            'visitor_name' => $validated['visitor_name'],
            'visitor_phone' => $validated['visitor_phone'],
            'note' => $validated['note'] ?? null,
            'ip' => $request->ip(),
        ]);

        return response()->json(['message' => 'Thank you — your details were shared with the card owner.'], 201);
    }

    /**
     * All phone/contact shares from visitors across the authenticated user's smart cards (newest first).
     */
    public function myVisitorContacts(Request $request)
    {
        $user = $request->user();

        $rows = QrVisitorContact::query()
            ->whereHas('qrgen', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->with(['qrgen:id,cardname,slug'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function (QrVisitorContact $c) {
                return [
                    'id' => $c->id,
                    'created_at' => $c->created_at,
                    'visitor_name' => $c->visitor_name,
                    'visitor_phone' => $c->visitor_phone,
                    'note' => $c->note,
                    'ip' => $c->ip,
                    'card_name' => $c->qrgen?->cardname,
                    'card_slug' => $c->qrgen?->slug,
                ];
            });

        return response()->json(['contacts' => $rows]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** @var SubscriptionService $svc */
        $svc = app(SubscriptionService::class);
        $sub = $svc->latestForUser((int) $request->input('user_id'));
        if (!$svc->isActive($sub)) {
            return response()->json([
                'message' => 'An active subscription is required to create a smart card.',
                'code'    => 'SUBSCRIPTION_REQUIRED',
            ], 403);
        }

        try {
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'cardname' => 'required|string',
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'email1' => 'nullable|email',
                'mobile1' => 'nullable',
                'address1' => 'nullable|string',

                'maincolor' => 'nullable|string',
                'gradientcolor' => 'nullable|string',
                'buttoncolor' => 'nullable|string',
                'summary' => 'nullable|string',
                'cardtype' => 'nullable|string',
                'status' => 'nullable|string',

                // Example: nullable status field
                'companyname' => 'nullable|string',
                'jobtitle' => 'nullable|string',
                'webaddress1' => 'nullable',
                'phone1' => 'nullable',
                'email2' => 'nullable|email',
                'slug' => 'nullable|string',
                'phone2' => 'nullable',
                'mobile2' => 'nullable',
                'mobile3' => 'nullable',
                'mobile4' => 'nullable',
                'fax' => 'nullable',
                'fax2' => 'nullable',
                'address2' => 'nullable|string',
                'webaddress2' => 'nullable',
                'checkgradient' => 'nullable|string',
                // 'appointment' => 'required',

                //social id
                'facebook' => 'nullable',
                'twitter' => 'nullable',
                'instagram' => 'nullable',
                'youtube' => 'nullable',
                'github' => 'nullable',

                'behance' => 'nullable',
                'linkedin' => 'nullable',
                'spotify' => 'nullable',
                'tumblr' => 'nullable',
                'telegram' => 'nullable',
                'pinterest' => 'nullable',
                'snapchat' => 'nullable',
                'reddit' => 'nullable',
                'google' => 'nullable',
                'apple' => 'nullable',
                'figma' => 'nullable',
                'discord' => 'nullable',
                'tiktok' => 'nullable',
                'whatsapp' => 'nullable',
                'skype' => 'nullable',
                'google_scholar' => 'nullable',
                'medium' => 'nullable',
                'wechat' => 'nullable',
                'social_links' => 'nullable|string',

                //social id end

                'qrcodeimage' => 'nullable',
                // ... other fields and validation rules
                'image' => 'nullable',
                'welcomeimage' => 'nullable',

                'smart_card_id' => 'nullable|exists:smart_cards,id',

            ]);

            $smartCardId = $validatedData['smart_card_id'] ?? null;

            if ($smartCardId !== null && $smartCardId !== '') {
                $authUser = $request->user();
                if (! $authUser || (int) $authUser->id !== (int) $request->input('user_id')) {
                    return response()->json(['message' => 'Unauthorized'], 403);
                }
            }

            $qrgen = new Qrgen($validatedData);
            SocialLinksHelper::hydrateQrgen($qrgen, $request);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = uniqid() . '-' . $image->getClientOriginalName();
                $image->move(public_path('image/qrgen/'), $imageName);
                $qrgen->image = 'image/qrgen/' . $imageName;
            }



            if ($request->hasFile('welcomeimage')) {
                $image = $request->file('welcomeimage');
                $imageName = uniqid() . '-' . str_replace(' ', '-', $image->getClientOriginalName());
                $image->move(public_path('image/qrgen/'), $imageName);
                $qrgen->welcome = 'image/qrgen/' . $imageName;
            }

            $qrgen->save();
            Log::info('Qrgen created successfully', ['id' => $qrgen->id]);

            $orderId = null;
            $skipCheckout = false;
            if ($smartCardId !== null && $smartCardId !== '') {
                $smartCard = SmartCard::find($smartCardId);
                if (! $smartCard) {
                    return response()->json(['status' => 422, 'errors' => ['smart_card_id' => ['Invalid design selected.']]], 422);
                }
                $unitPrice = $this->resolveSmartCardUnitPrice($smartCard);
                $noPaymentRequired = $this->isSmartCardPriceAndDiscountZero($smartCard);

                $order = new CardOrder();
                $order->user_id = $qrgen->user_id;
                $order->qrgen_id = $qrgen->id;
                $order->smart_card_id = (int) $smartCardId;
                $order->order_number = 'ORD-' . strtoupper(uniqid());
                $order->quantity = 1;
                $order->total_price = $unitPrice;
                if ($noPaymentRequired) {
                    $order->status = 'completed';
                    $order->payment_method = 'free';
                    $skipCheckout = true;
                } else {
                    $order->status = 'awaiting_checkout';
                }
                $order->save();
                $orderId = $order->id;
            }

            return response()->json([
                'status' => 200,
                'message' => 'Qrgen created successfully',
                'id' => $qrgen->id,
                'order_id' => $orderId,
                'skip_checkout' => $skipCheckout,
            ]);
        } catch (ValidationException $e) {
            // Return validation errors
            return response()->json(['status' => 422, 'errors' => $e->errors()]);
        } catch (\Throwable $e) {
            Log::error('Error creating Qrgen', ['error' => $e->getMessage()]);
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $slug, VisitorService $visitorService)
    {
        $showpost = Qrgen::where('slug', $slug)->first();
        if (!$showpost) {
            return response()->json(['error' => 'Qrgen not found'], 404);
        }

        if ($showpost->status === 'paused') {
            return response()->json(['error' => 'Qrgen is paused'], 403);
        }

        // Check the card owner's subscription regardless of card status
        /** @var SubscriptionService $svc */
        $svc = app(SubscriptionService::class);
        $sub = $svc->latestForUser((int) $showpost->user_id);
        if (!$svc->isActive($sub)) {
            return response()->json([
                'error'     => 'This card is currently unavailable. The owner\'s subscription has expired.',
                'code'      => 'SUBSCRIPTION_EXPIRED',
                'renew_url' => '/pricing',
            ], 403);
        }

        $showpost->increment('viewcount');

        $userIp    = $request->ip();
        $userAgent = $request->header('User-Agent');
        $userInfo  = $visitorService->getUserInfo($userIp, $userAgent, $showpost->id, 'visiting_id');
        $visitorService->saveVisitorInfo($userInfo, 'visiting_id');

        return response()->json($showpost);
    }

    public function getQrDetails($id)
    {
        $qrDetails = Qrgen::find($id);

        if (!$qrDetails) {
            return response()->json(['error' => 'Qrgen not found'], 404);
        }

        return response()->json(['qrDetails' => $qrDetails]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $qrgen = Qrgen::find($id);

        if (!$qrgen) {
            return response()->json(['error' => 'Qrgen not found'], 404);
        }

        return response()->json(['qrgen' => $qrgen]);
    }



    public function pause($id)
    {
        $qrgen = Qrgen::find($id);

        if (!$qrgen) {
            return response()->json(['error' => 'Qrgen not found'], 404);
        }

        // Update the status to 'paused'
        $qrgen->status = 'paused';
        $qrgen->save();

        return response()->json(['message' => 'Qrgen paused successfully']);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'cardname' => 'required|string',
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'email1' => 'nullable|email',
                'mobile1' => 'nullable|numeric',
                'address1' => 'nullable|string',
                'maincolor' => 'nullable|string',
                'gradientcolor' => 'nullable|string',
                'buttoncolor' => 'nullable|string',
                'summary' => 'nullable|string',
                'cardtype' => 'nullable|string',
                'status' => 'nullable|string',
                // Example: nullable status field
                'webaddress1' => 'nullable',
                'companyname' => 'nullable|string',
                'phone1' => 'nullable|numeric',
                'jobtitle' => 'nullable|string',
                'email2' => 'nullable|email',
                'slug' => 'nullable|string',
                'phone2' => 'nullable|numeric',
                'mobile2' => 'nullable|numeric',
                'mobile3' => 'nullable|numeric',
                'mobile4' => 'nullable|numeric',
                'fax' => 'nullable|numeric',
                'fax2' => 'nullable|numeric',
                'address2' => 'nullable|string',
                'webaddress2' => 'nullable',
                'checkgradient' => 'nullable|string',
                // 'appointment' => 'required',

                'facebook' => 'nullable|url',
                'twitter' => 'nullable|url',
                'instagram' => 'nullable|url',
                'youtube' => 'nullable|url',
                'github' => 'nullable|url',

                'behance' => 'nullable|url',
                'linkedin' => 'nullable|url',
                'spotify' => 'nullable|url',
                'tumblr' => 'nullable|url',
                'telegram' => 'nullable|url',
                'pinterest' => 'nullable|url',
                'snapchat' => 'nullable|url',
                'reddit' => 'nullable|url',
                'google' => 'nullable|url',
                'apple' => 'nullable|url',
                'figma' => 'nullable|url',
                'discord' => 'nullable|url',
                'tiktok' => 'nullable|url',
                'whatsapp' => 'nullable|url',
                'skype' => 'nullable|url',
                'google_scholar' => 'nullable|url',
                'medium' => 'nullable|url',
                'wechat' => 'nullable|url',
                'social_links' => 'nullable|string',

                'qrcodeimage' => 'nullable',
                // ... other fields and validation rules
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
                'welcomeimage' => 'nullable',
            ]);
            $qrgen = Qrgen::findOrFail($id);
            $qrgen->fill($validatedData);
            SocialLinksHelper::hydrateQrgen($qrgen, $request);
            $qrgen->save();
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = uniqid() . '-' . $image->getClientOriginalName();
                $image->move(public_path('image/qrgen/'), $imageName);
                $qrgen->image = 'image/qrgen/' . $imageName;
            }
            if ($request->hasFile('welcomeimage')) {
                $image = $request->file('welcomeimage');
                $oldWelcome = $qrgen->welcome;
                $imageName = uniqid() . '-' . str_replace(' ', '-', $image->getClientOriginalName());
                $image->move(public_path('image/qrgen/'), $imageName);
                $qrgen->welcome = 'image/qrgen/' . $imageName;
                if ($oldWelcome && file_exists(public_path($oldWelcome))) {
                    unlink(public_path($oldWelcome));
                }
            }
            $qrgen->save();
            Log::info('Qrgen updated successfully', ['id' => $qrgen->id]);
            return response()->json([
                'status' => 200,
                'message' => 'Qrgen updated successfully',
            ]);
        } catch (ValidationException $e) {
            // Return validation errors
            return response()->json(['status' => 422, 'errors' => $e->errors()]);
        } catch (\Throwable $e) {
            Log::error(
                'Error updating Qrgen',
                ['error' => $e->getMessage()]
            );
            return response()->json(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $qrgen = Qrgen::find($id);

        if (!$qrgen) {
            return response()->json(['error' => 'Qrgen not found'], 404);
        }

        $imagePath = $qrgen->image;
        $welcomeImagePath = $qrgen->welcome;

        $qrgen->delete();

        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }

        if ($welcomeImagePath && file_exists($welcomeImagePath)) {
            unlink($welcomeImagePath);
        }

        return response()->json(['message' => 'Qrgen deleted successfully']);
    }

    private function resolveSmartCardUnitPrice(SmartCard $card): float
    {
        $discount = $card->discount_price;
        if ($discount !== null && $discount !== '' && (float) $discount > 0) {
            return round((float) $discount, 2);
        }

        return round((float) ($card->price ?? 0), 2);
    }

    /**
     * True when list price and discount list price are both zero (no checkout / payment).
     */
    private function isSmartCardPriceAndDiscountZero(SmartCard $card): bool
    {
        $p = (float) ($card->price ?? 0);
        $d = (float) ($card->discount_price ?? 0);

        return $p <= 0.0 && $d <= 0.0;
    }
}
