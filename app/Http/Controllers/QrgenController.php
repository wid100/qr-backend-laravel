<?php

namespace App\Http\Controllers;

use App\Models\Qrgen;
use Illuminate\Http\Request;

use App\Models\User;
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
        $getqr = Qrgen::where('user_id', $user->id)->get();

        return response()->json(['getqr' => $getqr]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'cardname' => 'required|string',
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'email1' => 'required|email',
                'mobile1' => 'required|numeric',
                'address1' => 'required|string',

                'maincolor' => 'required|string',
                'gradientcolor' => 'required|string',
                'buttoncolor' => 'required|string',
                'summary' => 'required|string',
                'cardtype' => 'required|string',
                'status' => 'required|string',

                // Example: nullable status field
                'companyname' => 'nullable|string',
                'jobtitle' => 'nullable|string',
                'webaddress1' => 'nullable',
                'phone1' => 'nullable|numeric',
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
                'appointment' => 'required',

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



                //social id end

                'qrcodeimage' => 'nullable',
                // ... other fields and validation rules
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
                'welcomeimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'phone1.numeric' => 'The Phone field accepet only number.',
                'cardname.required' => 'The card name field is required.',
                'firstname.required' => 'The first name field is required.',
                'lastname.required' => 'The last name field is required.',
                'email1.required' => 'The email field is required.',
                'email1.email' => 'The email field must be an email.',
                // ... other custom error messages
                'image.required' => 'The image field is required.',
                'image.image' => 'The file must be an image.',
                'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
                'image.max' => 'The image may not be greater than 5MB.',

            ]);

            $qrgen = new Qrgen($validatedData);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = uniqid() . '-' . $image->getClientOriginalName();
                $image->move(public_path('image/qrgen/'), $imageName);
                $qrgen->image = 'image/qrgen/' . $imageName;
            }



            if ($request->hasFile('welcomeimage')) {
                $image = $request->file('welcomeimage');
                $imageName = str_replace(' ', '-', $image->getClientOriginalName()); // Replace spaces with dashes
                $image->move(public_path('image/qrgen/'), $imageName);
                $qrgen->welcome = 'image/qrgen/' . $imageName;
            }

            $qrgen->save();
            Log::info('Qrgen created successfully', ['id' => $qrgen->id]);

            return response()->json([
                'status' => 200,
                'message' => 'Qrgen created successfully',
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
                'email1' => 'required|email',
                'mobile1' => 'required|numeric',
                'address1' => 'required|string',
                'maincolor' => 'required|string',
                'gradientcolor' => 'required|string',
                'buttoncolor' => 'required|string',
                'summary' => 'required|string',
                'cardtype' => 'required|string',
                'status' => 'required|string',
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
                'appointment' => 'required',

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



                'qrcodeimage' => 'nullable',
                // ... other fields and validation rules
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
                'welcomeimage' => 'nullable',
            ]);
            $qrgen = Qrgen::findOrFail($id);
            $qrgen->update($validatedData);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = uniqid() . '-' . $image->getClientOriginalName();
                $image->move(public_path('image/qrgen/'), $imageName);
                $qrgen->image = 'image/qrgen/' . $imageName;
            }
            if ($request->hasFile('welcomeimage')) {
                $image = $request->file('welcomeimage');
                $imageName = str_replace(' ', '-', $image->getClientOriginalName());
                $image->move(public_path('image/qrgen/'), $imageName);
                $qrgen->welcome = 'image/qrgen/' . $imageName;
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
}
