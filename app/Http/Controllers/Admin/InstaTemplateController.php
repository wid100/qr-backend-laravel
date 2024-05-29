<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\InstaCategory;
use App\Models\InstaTemplate;
use App\Http\Controllers\Controller;

class InstaTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = InstaTemplate::all();
        return view('admin.instatemplate.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $insta_category = InstaCategory::all();
        return view('admin.instatemplate.create', compact('insta_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'insta_category' => 'required',
            'template' => 'required',
        ]);

        $status = $request->has('status') ? 1 : 0;
        $insta_template = new InstaTemplate();
        $insta_template->template = $validatedData['template'];
        $insta_template->insta_category = $validatedData['insta_category'];
        $insta_template->status = $status;

        $insta_template->save();

        return redirect()->route('admin.instatemplate.index')->with('success', 'Insta Template created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InstaTemplate  $instaTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(InstaTemplate $instaTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstaTemplate  $instaTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $insta_category = InstaCategory::all();
        $template = InstaTemplate::find($id);
        return view('admin.instatemplate.edit', compact('template', 'insta_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstaTemplate  $instaTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'insta_category' => 'required',
            'template' => 'required',
        ]);

        $status = $request->has('status') ? 1 : 0;
        $insta_template = InstaTemplate::findOrFail($id);
        $insta_template->template = $validatedData['template'];
        $insta_template->insta_category = $validatedData['insta_category'];
        $insta_template->status = $status;

        $insta_template->save();

        return redirect()->route('admin.instatemplate.index')->with('success', 'Insta Template Update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstaTemplate  $instaTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $template = InstaTemplate::find($id);
        $template->delete();
        return redirect()->back()->with('success', 'Template Delete Success');
    }
}
