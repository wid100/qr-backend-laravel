<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Template;
use App\Http\Controllers\Controller;
use App\Models\Admin\TemplateCategory;
use App\Http\Requests\Admin\TemplateCreateRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $template = Template::with('templateCategory')->get();
        // dd($template);
        return view('admin.template.index', compact('template'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $template_category = TemplateCategory::all();
        return view('admin.template.create', compact('template_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemplateCreateRequest $request)
    {
        // dd($request->all());
        $data = [
            'template_category_id' => $request->cat_id,
            'name' => $request->name,
            'primary_color' => $request->primary_color,
            'text_color' => $request->text_color,
            'code' => $request->code,
        ];

        $image = $request->file('image');
        if ($image) {
            $reviewDirectory = public_path('image/template');
            File::makeDirectory($reviewDirectory, 0755, true, true);

            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $uniqueName = $originalName . '_' . Str::random(20) . '_' . uniqid() . '.webp';

            Image::make($image)->save($reviewDirectory . '/' . $uniqueName, 80, 'webp');
            $data['image'] = 'image/template/' . $uniqueName;
        }

        Template::create($data);
        return redirect()->route('admin.template.index')->with('success', 'Template created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {
        $template_category = TemplateCategory::all();
        return view('admin.template.edit', compact('template', 'template_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(TemplateCreateRequest $request, Template $template)
    {
        $data = [
            'template_category_id' => $request->cat_id,
            'name' => $request->name,
            'primary_color' => $request->primary_color,
            'text_color' => $request->text_color,
            'code' => $request->code,
        ];

        $image = $request->file('image');
        if ($image) {

            if ($template->image) {
                File::delete(public_path($template->image));
            }

            $reviewDirectory = public_path('image/template');
            File::makeDirectory($reviewDirectory, 0755, true, true);

            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $uniqueName = $originalName . '_' . Str::random(20) . '_' . uniqid() . '.webp';

            Image::make($image)->save($reviewDirectory . '/' . $uniqueName, 80, 'webp');
            $data['image'] = 'image/template/' . $uniqueName;
        }

        $template->update($data);
        return redirect()->route('admin.template.index')->with('success', 'Template updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        if ($template->image) {
            File::delete(public_path($template->image));
        }
        $template->delete();
        return redirect()->route('admin.template.index')->with('success', 'Template deleted successfully.');
    }
}
