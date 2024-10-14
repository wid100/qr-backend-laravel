<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\FAQSection;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {
        $faq = FAQSection::with(['questions' => function ($query) {
            $query->where('status', 0);
        }])->where('status', 0)->get();

        return response()->json($faq, 200);
    }
}
