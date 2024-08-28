<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Template;
use App\Models\Admin\TemplateCategory;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTemplates($id)
    {

        if ($id == 'all') {
            $templates = Template::all();
        } else {
            // $templates = TemplateCategory::with('templates')->findOrFail($id);
            $templates = Template::where('template_category_id', $id)->get();
        }
        return response()->json($templates);
    }
    public function getTemplate($id)
    {
        $template = Template::findOrFail($id);
        return response()->json($template);
    }
}
