<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Resume;
use PDF;

class ResumeController extends Controller
{
    public function generatePdf($userId, $templateId)
    {
        // Fetch the resume data
        $resume = Resume::where('user_id', $userId)->firstOrFail();

        // View name based on templateId
        $viewName = "resume.templates.template{$templateId}";

        // Generate the PDF
        $pdf = PDF::loadView($viewName, compact('resume'))
            ->setPaper('a4', 'portrait') // A4 size in portrait
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]); // Support for HTML5 & remote resources

        // Return the PDF as a download
        return $pdf->download('resume_' . $userId . '.pdf');
    }

    public function viewPdf($userId, $templateId)
    {
        // Fetch the resume data for the given user
        $resume = Resume::where('user_id', $userId)->firstOrFail();

        // View name based on templateId
        $viewName = "resume.templates.template{$templateId}";

        // Generate the PDF using the template and data
        $pdf = PDF::loadView($viewName, compact('resume'))
            ->setPaper('a4', 'portrait') // A4 size in portrait
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        // Return the PDF as a stream to the browser
        return $pdf->stream('resume_' . $userId . '.pdf');
    }
}
