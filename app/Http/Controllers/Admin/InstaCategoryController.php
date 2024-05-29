<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstaCategory;
use Illuminate\Http\Request;

class InstaCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $insta_category = InstaCategory::all();
        return view('admin.instacategory.index', compact('insta_category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.instacategory.create');
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
            'name' => 'required|string|max:255',
        ]);

        $status = $request->has('status') ? 1 : 0;
        $insta_category = new InstaCategory();
        $insta_category->name = $validatedData['name'];
        $insta_category->status = $status;

        $insta_category->save();

        return redirect()->route('admin.instacategory.index')->with('success', 'Insta Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InstaCategory  $instaCategory
     * @return \Illuminate\Http\Response
     */
    public function show(InstaCategory $instaCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InstaCategory  $instaCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = InstaCategory::find($id);
        return view('admin.instacategory.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstaCategory  $instaCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $status = $request->has('status') ? 1 : 0;
        $insta_category = InstaCategory::findOrFail($id);
        $insta_category->name = $validatedData['name'];
        $insta_category->status = $status;

        $insta_category->save();

        return redirect()->route('admin.instacategory.index')->with('success', 'Insta Category Update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstaCategory  $instaCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = InstaCategory::find($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category Delete Success');
    }
}
