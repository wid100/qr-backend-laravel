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
                'facebook' => 'nullable|url',
                'twitter' => 'nullable|url',
                'instagram' => 'nullable|url',
                'youtube' => 'nullable|url',
                'github' => 'nullable|url',
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

            // if ($request->hasFile('welcomeimage')) {
            //     $image = $request->file('welcomeimage');
            //     $imageName = $image->getClientOriginalName();
            //     $image->move(public_path('image/qrgen/'), $imageName);
            //     $qrgen->welcome = 'image/qrgen/' . $imageName;
            // }

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

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     $qrgen = Qrgen::find($id);
    //     Log::info('Received Request Data: ', $request->all());
    //     Log::info('Updated Qrgen Data: ', $qrgen->toArray());
    //     if (!$qrgen) {
    //         return response()->json(['error' => 'Qrgen not found'], 404);
    //     }

    //     // Update the resource with the provided data
    //     $qrgen->user_id = $request->input('user_id');
    //     $qrgen->cardname = $request->input('cardname');
    //     $qrgen->firstname = $request->input('firstname');
    //     $qrgen->lastname = $request->input('lastname');
    //     $qrgen->email1 = $request->input('email1');
    //     $qrgen->email2 = $request->input('email2');
    //     $qrgen->phone1 = $request->input('phone1');
    //     $qrgen->phone2 = $request->input('phone2');
    //     $qrgen->mobile1 = $request->input('mobile1');
    //     $qrgen->mobile2 = $request->input('mobile2');
    //     $qrgen->mobile3 = $request->input('mobile3');
    //     $qrgen->mobile4 = $request->input('mobile4');
    //     $qrgen->fax = $request->input('fax');
    //     $qrgen->fax2 = $request->input('fax2');
    //     $qrgen->address1 = $request->input('address1');
    //     $qrgen->address2 = $request->input('address2');
    //     $qrgen->webaddress1 = $request->input('webaddress1');
    //     $qrgen->webaddress2 = $request->input('webaddress2');
    //     $qrgen->companyname = $request->input('companyname');
    //     $qrgen->jobtitle = $request->input('jobtitle');
    //     $qrgen->maincolor = $request->input('maincolor');
    //     $qrgen->gradientcolor = $request->input('gradientcolor');
    //     $qrgen->buttoncolor = $request->input('buttoncolor');
    //     $qrgen->checkgradient = $request->input('checkgradient');
    //     $qrgen->summary = $request->input('summary');
    //     $qrgen->cardType = $request->input('cardtype');
    //     $qrgen->facebook = $request->input('facebook');
    //     $qrgen->twitter = $request->input('twitter');
    //     $qrgen->instagram = $request->input('instagram');
    //     $qrgen->youtube = $request->input('youtube');
    //     $qrgen->github = $request->input('github');
    //     $qrgen->facebook = $request->input('facebook');
    //     $qrgen->qrcodeimage = $request->input('qrCodeImage');
    //     $qrgen->status = $request->input('status');

    //     // Handle file uploads (similar to your store method)
    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $imageName = uniqid() . '-' . $image->getClientOriginalName();
    //         $image->move(public_path('image/qrgen/'), $imageName);
    //         $qrgen->image = 'image/qrgen/' . $imageName;
    //     }

    //     if ($request->hasFile('welcomeimage')) {
    //         $image = $request->file('welcomeimage');
    //         $imageName = uniqid() . '-' . $image->getClientOriginalName();
    //         $image->move(public_path('image/qrgen/'), $imageName);
    //         $qrgen->welcome = 'image/qrgen/' . $imageName;
    //     }

    //     // Save the updated resource
    //     $qrgen->save();

    //     return response()->json(['status' => 200, 'message' => 'Qrgen updated successfully']);
    // }

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
                'facebook' => 'nullable|url',
                'twitter' => 'nullable|url',
                'instagram' => 'nullable|url',
                'youtube' => 'nullable|url',
                'github' => 'nullable|url',
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
