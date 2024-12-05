<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InstaCategory;
use App\Models\InstaTemplate;

class InstaController extends Controller
{
    // public function allCategory()
    // {
    //     $category = InstaCategory::where('status', '1')->get();
    //     return response()->json($category);
    // }

    public function allCategory()
    {
        $categories = InstaCategory::with('instaTemplates')->get();
        return response()->json($categories);
    }
}
