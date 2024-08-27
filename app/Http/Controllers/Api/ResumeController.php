<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResumeRequest;
use App\Http\Requests\ResumeUpdate;
use App\Http\Resources\ResumeResource;
use App\Models\Admin\Resume;
use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resumes = Resume::all();
        return response()->json($resumes);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return response()->json($request->photo);
        // if ($request->hasFile('photo')) {
        //     $file = $request->file('photo');
        //     return response()->json([
        //         'file_name' => $file->getClientOriginalName(),
        //         'file_type' => $file->getMimeType(),
        //         'file_size' => $file->getSize(),
        //     ]);
        // } else {
        //     return response()->json(['message' => 'No file uploaded'], 400);
        // }

        $resume = new Resume();

        // $data = $request->resume['name'];
        // return response()->json($data);


        return response()->json($resume->create_function());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function show(Resume $resume)
    {

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
    public function update(ResumeUpdate $request, Resume $id)
    {
        return response()->json($id);

        $resume->update_resume();

        $updated_resource = $resume->fresh();
        return response()->json([
            'message' => 'Resume updated successfully',
            'data' => $updated_resource,
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
        $resume->delete();
        return response()->json([
            'message' => 'Resume deleted successfully'
        ], 200);
    }
}
