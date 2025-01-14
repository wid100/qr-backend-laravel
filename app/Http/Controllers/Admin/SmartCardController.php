<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SmartCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SmartCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards = SmartCard::all();
        // dd($cards);
        return view('admin.smart-card.index', ['cards' => $cards]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.smart-card.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'description' => 'required|string',
            'status' => 'nullable|in:on,off',
            'front_image' => 'required|image|mimes:jpg,jpeg,png,gif',
            'back_image' => 'required|image|mimes:jpg,jpeg,png,gif',
        ]);
        $frontImage = $request->file('front_image');
        $backImage = $request->file('back_image');

        // Generate a unique name for each image with a hash
        $frontImageName = Str::random(10) . '_' . time() . '.' . $frontImage->getClientOriginalExtension();
        $backImageName = Str::random(10) . '_' . time() . '.' . $backImage->getClientOriginalExtension();

        // Store the images with the new names
        $frontImagePath = $frontImage->storeAs('image/smartcard', $frontImageName, 'public');
        $backImagePath = $backImage->storeAs('image/smartcard', $backImageName, 'public');

        // Create a new Card record
        $card = new SmartCard();
        $card->name = $request->name;
        $card->price = $request->price;
        $card->discount_price = $request->discount_price;
        $card->description = $request->description;
        $card->status = ($request->status === 'on') ? 0 : 1;
        $card->font_image = $frontImagePath;
        $card->back_image = $backImagePath;
        $card->save();
        return redirect()->route('admin.smart-card.index')->with('success', 'Card successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\SmartCard  $smartCard
     * @return \Illuminate\Http\Response
     */
    public function show(SmartCard $smartCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\SmartCard  $smartCard
     * @return \Illuminate\Http\Response
     */
    public function edit(SmartCard $smartCard)
    {
        return view('admin.smart-card.edit', ['card' => $smartCard]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\SmartCard  $smartCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SmartCard $SmartCard)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'description' => 'required|string',
            'status' => 'nullable|in:on,off',
            'front_image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'back_image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
        ]);

        // Handle front image if uploaded
        if ($request->hasFile('front_image')) {
            $frontImage = $request->file('front_image');
            $frontImageName = Str::random(10) . '_' . time() . '.' . $frontImage->getClientOriginalExtension();
            $frontImagePath = $frontImage->storeAs('image/smartcard', $frontImageName, 'public');

            // Delete the old image if it exists
            if ($SmartCard->font_image) {
                Storage::disk('public')->delete($SmartCard->font_image);
            }

            $SmartCard->font_image = $frontImagePath; // Update the front image path
        }

        // Handle back image if uploaded
        if ($request->hasFile('back_image')) {
            $backImage = $request->file('back_image');
            $backImageName = Str::random(10) . '_' . time() . '.' . $backImage->getClientOriginalExtension();
            $backImagePath = $backImage->storeAs('image/smartcard', $backImageName, 'public');

            // Delete the old image if it exists
            if ($SmartCard->back_image) {
                Storage::disk('public')->delete($SmartCard->back_image);
            }

            $SmartCard->back_image = $backImagePath; // Update the back image path
        }

        // Save the updated record
        $SmartCard->update([
            'name' => $request->name,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'description' => $request->description,
            'status' => ($request->status === 'on') ? 0 : 1,
        ]);

        return redirect()->route('admin.smart-card.index')->with('success', 'Card successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\SmartCard  $smartCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(SmartCard $smartCard)
    {
        // Delete the images if they exist
        // dd($smartCard);
        if ($smartCard->font_image) {
            Storage::disk('public')->delete($smartCard->font_image);
        }

        if ($smartCard->back_image) {
            Storage::disk('public')->delete($smartCard->back_image);
        }

        // Delete the smart card
        $smartCard->delete();

        return redirect()->route('admin.smart-card.index')->with('success', 'Card successfully deleted');
    }
}
