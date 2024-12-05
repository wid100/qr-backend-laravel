<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\TemplateCategory;
use Illuminate\Http\Request;

class TemplateCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tempcategory = TemplateCategory::all();
        return view('admin.temcategory.index', compact('tempcategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.temcategory.create',);
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
            'name' => 'required',
        ]);

        TemplateCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.tempcategory.index')->with('success', 'Template Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\TemplateCategory  $templateCategory
     * @return \Illuminate\Http\Response
     */
    public function show(TemplateCategory $templateCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\TemplateCategory  $templateCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = TemplateCategory::findOrFail($id);
        return view('admin.temcategory.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\TemplateCategory  $templateCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'name' => 'required'
        ]);
        $category = TemplateCategory::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.tempcategory.index')->with('success', 'Template category updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\TemplateCategory  $templateCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = TemplateCategory::find($id);
        $category->delete();
        return redirect()->back()->with('success', 'Template category Delete Success');
    }
}
