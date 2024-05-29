<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InstaCategory;
use App\Models\InstaTemplate;

class InstaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allCategory()
    {
        $category = InstaCategory::where('status', '1')->get();
        return response()->json($category);
    }



    public function allTemplate()
    {
        $template = InstaTemplate::where('status', '1')->get();
        return response()->json($template);
    }
}
