<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResumeRequest;
use App\Http\Requests\ResumeUpdate;
use App\Http\Resources\ResumeResource;
use App\Models\Admin\Resume;
use App\Models\Admin\Visitor;
use App\Services\VisitorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Validation\ValidationException;
use Stevebauman\Location\Facades\Location;
use Stevebauman\Location\Facades\Location as FacadesLocation;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        // $resumes = Resume::with('template')->where('user_id', $userId)->where('status', 0)->get();

        $resumes = Resume::with(['template', 'visitors'])
            ->where('user_id', $userId)
            ->where('status', 0)
            ->get();
        return ResumeResource::collection($resumes);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResumeRequest $request)
    {

        $resume = new Resume();
        return response()->json($resume->create_function());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug,  VisitorService $visitorService)
    {
        $resume =  Resume::where('slug', $slug)->first();
        $resume->increment('viewcount');

        // Get user IP and User-Agent
        $userIp = $request->ip();
        // $ip = '59.153.103.119';
        $userAgent = $request->header('User-Agent');

        // Use the service to gather user info
        $userInfo = $visitorService->getUserInfo($userIp, $userAgent, $resume->id, 'resume_id');
        $visitorService->saveVisitorInfo($userInfo, 'resume_id');

        // return response()->json($userInfo);

        // Return the resume resource
        return new ResumeResource($resume);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function edit(Resume $resume)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function update(ResumeUpdate $request, Resume $resume)
    {

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $directory = public_path('image/resume');
            if (!file_exists($directory)) {
                mkdir($directory, 0775, true);
            }
            $manager = new ImageManager(['driver' => 'gd']);
            $name_gen = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();

            $img = $manager->make($file);
            $img->save($directory . '/' . $name_gen, 80);

            $resume->photo = 'image/resume/' . $name_gen;
        }

        $resume->template_id = $request->input('templateId');
        $resume->resume_name = $request->input('resume_name');
        $resume->title = $request->input('profession');
        $resume->description = $request->input('description');
        $resume->phone = $request->input('phone');
        $resume->email = $request->input('email');
        $resume->address = $request->input('address');
        $resume->education = $request->input('education');
        $resume->skill = $request->input('skills');
        $resume->language = $request->input('languages');
        $resume->interest = $request->input('interests');
        $resume->experience = $request->input('jobs');
        $resume->references = $request->input('references');
        $resume->social = $request->input('social');
        $resume->fname = $request->input('firstName');
        $resume->lname = $request->input('lastName');
        $resume->primary_color = $request->input('primaryColor');
        $resume->text_color = $request->input('textColor');
        $resume->profession = $request->input('profession');
        $resume->city = $request->input('city');
        $resume->postal_code = $request->input('postal_code');
        $resume->country = $request->input('country');
        $resume->other = $request->input('other');
        $resume->save();


        return response()->json([
            'message' => 'Resume updated successfully',
            'data' => new ResumeResource($resume)
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resume $resume)
    {
        if ($resume->photo) {
            File::delete(public_path($resume->photo));
        }
        $resume->delete();
        return response()->json([
            'message' => 'Resume deleted successfully'
        ], 200);
    }
}
