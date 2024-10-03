<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resumes = Resume::latest()->get();
        return view('admin.resume.index', compact('resumes'));
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
        $resume = Resume::find($id);
        // $education = json_decode($resume->education);
        // dd($education[0]->institution);
        return view('admin.resume.edit', compact('resume'));
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
        $resume = Resume::find($id);
        $resume->update([
            'resume_name' => $request->resume_name,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'title' => $request->title,
            'profession' => $request->profession,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'skill' => $request->skills,
            'language' => $request->languages,
            'interest' => $request->interest,
            'education' => $request->education,
            'experience' => $request->work,
            'references' => $request->references,
        ]);
        dd('sucessfully');
        // return redirect()->route('admin.resume.index')->with('success', 'Resume updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resume = Resume::find($id);
        if ($resume->photo) {
            File::delete(public_path($resume->photo));
        }
        $resume->delete();
        return redirect()->back()->with('success', 'Resume deleted successfully');
    }
}
