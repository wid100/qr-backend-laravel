<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\TemplateCategory as AdminTemplateCategory;
use Illuminate\Http\Request;

class TemplateCategory extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $template = AdminTemplateCategory::all();
        return response()->json($template);
    }
}
