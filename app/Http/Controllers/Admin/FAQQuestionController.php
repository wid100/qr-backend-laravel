<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\FAQQuestion;
use App\Models\Admin\FAQSection;
use Illuminate\Http\Request;

class FAQQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fAQQuestion = FAQQuestion::with('section')->get();
        return view('admin.faq-question.index', compact('fAQQuestion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faq_section = FAQSection::where('status', 0)->latest()->get();
        return view('admin.faq-question.create', compact('faq_section'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required',
            'question' => 'required|string|max:255',
            'answer' => 'required',
            'status' => 'required',
        ]);

        FAQQuestion::create([
            'f_a_q_section_id' => $request->section,
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.faq-question.index')->with('success', 'FAQ Question created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\FAQQuestion  $fAQQuestion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = FAQQuestion::with('section')->find($id);
        return view('admin.faq-question.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\FAQQuestion  $fAQQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = FAQQuestion::find($id);
        $faq_section = FAQSection::where('status', 0)->latest()->get();
        return view('admin.faq-question.edit', compact('question', 'faq_section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'section' => 'required',
            'question' => 'required|string|max:255',
            'answer' => 'required',
            'status' => 'required',
        ]);
        $question = FAQQuestion::find($id);
        $question->update([
            'f_a_q_section_id' => $request->section,
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.faq-question.index')->with('success', 'FAQ Question updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = FAQQuestion::find($id);
        if ($question) {
            $question->delete();
            return redirect()->route('admin.faq-question.index')->with('success', 'FAQ Question deleted successfully.');
        } else {
            return redirect()->route('admin.faq-question.index')->with('error', 'FAQ Question not found.');
        }
    }
}
