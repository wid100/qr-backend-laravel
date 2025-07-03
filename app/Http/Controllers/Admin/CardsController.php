<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Qrgen;

class CardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards = Qrgen::get();
        return view('admin.card.index', compact('cards'));
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
        $card = Qrgen::findOrFail($id);
        return view('admin.card.edit', compact('card'));
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
        $request->validate([

            'image' => 'nullable',
        ]);


        $card = Qrgen::findOrFail($id);


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '-' . $image->getClientOriginalName();
            $image->move(public_path('image/qrgen/'), $imageName);
            $card->image = 'image/qrgen/' . $imageName;
        }

        $card->save();

        return redirect()->route('admin.card.index')->with('success', 'Card updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $card = Qrgen::findOrFail($id);
        $card->delete();
        return redirect()->route('admin.card.index')->with('success', 'Card deleted successfully.');
    }
}
