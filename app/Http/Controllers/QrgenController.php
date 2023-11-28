<?php

namespace App\Http\Controllers;

use App\Models\Qrgen;
use Illuminate\Http\Request;

class QrgenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $qrgen = new Qrgen();
        $qrgen->user_id = $request->input('user_id');
        $qrgen->cardname = $request->input('cardname');
        $qrgen->firstname = $request->input('firstname');
        $qrgen->lastname = $request->input('lastname');
        $qrgen->email1 = $request->input('email1');
        $qrgen->email2 = $request->input('email2');
        $qrgen->phone1 = $request->input('phone1');
        $qrgen->phone2 = $request->input('phone2');
        $qrgen->mobile1 = $request->input('mobile1');
        $qrgen->mobile2 = $request->input('mobile2');
        $qrgen->mobile3 = $request->input('mobile3');
        $qrgen->mobile4 = $request->input('mobile4');
        $qrgen->fax = $request->input('fax');
        $qrgen->fax2 = $request->input('fax2');
        $qrgen->address1 = $request->input('address1');
        $qrgen->address2 = $request->input('address2');
        $qrgen->webaddress1 = $request->input('webaddress1');
        $qrgen->webaddress2 = $request->input('webaddress2');
        $qrgen->companyname = $request->input('companyname');
        $qrgen->jobtitle = $request->input('jobtitle');
        $qrgen->maincolor = $request->input('maincolor');
        $qrgen->gradientcolor = $request->input('gradientcolor');
        $qrgen->buttoncolor = $request->input('buttoncolor');
        $qrgen->checkgradient = $request->input('checkgradient');
        $qrgen->summary = $request->input('summary');
        $qrgen->cardType = $request->input('cardtype');
        $qrgen->slug = $request->input('slug');
        $qrgen->facebook = $request->input('facebook');
        $qrgen->twitter = $request->input('twitter');
        $qrgen->instagram = $request->input('instagram');
        $qrgen->youtube = $request->input('youtube');
        $qrgen->github = $request->input('github');
        $qrgen->facebook = $request->input('facebook');
        $qrgen->qrcodeimage = $request->input('qrCodeImage');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '-' . $image->getClientOriginalName();
            $image->move(public_path('image/qrgen/'), $imageName);
            $qrgen->image = 'image/qrgen/' . $imageName;
        }

        if ($request->hasFile('welcomeimage')) {
            $image = $request->file('welcomeimage');
            $imageName = uniqid() . '-' . $image->getClientOriginalName();
            $image->move(public_path('image/qrgen/'), $imageName);
            $qrgen->welcome = 'image/qrgen/' . $imageName;
        }

        $qrgen->save();
        return response()->json([
            'status' => 200,
            'message' => 'qrgen created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $showpost = Qrgen::where('slug', $slug)->first();

        if ($showpost) {
            return response()->json($showpost);
        } else {
            return response()->json(['error' => 'Post not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Qrgen $qrgen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Qrgen $qrgen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Qrgen $qrgen)
    {
        //
    }
}
