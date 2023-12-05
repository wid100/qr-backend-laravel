<?php

namespace App\Http\Controllers;

use App\Models\Qrgen;
use Illuminate\Http\Request;

use App\Models\User;

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
        $getqr = Qrgen::where('user_id', $user->id)->get();

        return response()->json(['getqr' => $getqr]);
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
        $qrgen->status = $request->input('status');

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
        if (!$showpost) {
            return response()->json(['error' => 'Qrgen not found'], 404);
        }


        if ($showpost->status === 'active') {
            $showpost->increment('viewcount');
            return response()->json($showpost);
        } else {
            return response()->json(['error' => 'Qrgen is paused'], 403);
        }
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $qrgen = Qrgen::find($id);


        if (!$qrgen) {
            return response()->json(['error' => 'Qrgen not found'], 404);
        }

        // Update the resource with the provided data
        $qrgen->fill([
            'user_id' => $request->input('user_id'),
            'cardname' => $request->input('cardname'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email1' => $request->input('email1'),
            'email2' => $request->input('email2'),
            'phone1' => $request->input('phone1'),
            'phone2' => $request->input('phone2'),
            'mobile1' => $request->input('mobile1'),
            'mobile2' => $request->input('mobile2'),
            'mobile3' => $request->input('mobile3'),
            'mobile4' => $request->input('mobile4'),
            'fax' => $request->input('fax'),
            'fax2' => $request->input('fax2'),
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'webaddress1' => $request->input('webaddress1'),
            'webaddress2' => $request->input('webaddress2'),
            'companyname' => $request->input('companyname'),
            'jobtitle' => $request->input('jobtitle'),
            'maincolor' => $request->input('maincolor'),
            'gradientcolor' => $request->input('gradientcolor'),
            'buttoncolor' => $request->input('buttoncolor'),
            'checkgradient' => $request->input('checkgradient'),
            'summary' => $request->input('summary'),
            'cardType' => $request->input('cardtype'),
            'slug' => $request->input('slug'),
            'facebook' => $request->input('facebook'),
            'twitter' => $request->input('twitter'),
            'instagram' => $request->input('instagram'),
            'youtube' => $request->input('youtube'),
            'github' => $request->input('github'),
            'qrcodeimage' => $request->input('qrCodeImage'),
            'status' => $request->input('status'),
        ]);

        // Handle file uploads (similar to your store method)
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

        // Save the updated resource
        $qrgen->save();

        return response()->json(['status' => 200, 'message' => 'Qrgen updated successfully']);
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
}
