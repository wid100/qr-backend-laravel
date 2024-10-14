<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\FAQSection;
use Illuminate\Http\Request;

class FAQSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqSections = FAQSection::latest()->get();
        return view('admin.faq-section.index', compact('faqSections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faq-section.create');
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
            'title' => 'required|string|max:255',
        ]);

        FAQSection::create([
            'title' => $request->title,
            'status' => $request->status
        ]);

        return redirect()->route('admin.faq-section.index')->with('success', 'FAQ Section created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\FAQSection  $fAQSection
     * @return \Illuminate\Http\Response
     */
    public function show(FAQSection $fAQSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\FAQSection  $fAQSection
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faqSection = FAQSection::find($id);
        return view('admin.faq-section.edit', compact('faqSection'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $faqSection = FAQSection::find($id);
        $faqSection->update([
            'title' => $request->title,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.faq-section.index')->with('success', 'FAQ Section updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\FAQSection  $fAQSection
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fAQSection =  FAQSection::find($id);
        $fAQSection->delete();
        return redirect()->route('admin.faq-section.index')->with('success', 'FAQ Section deleted successfully.');
    }
}
