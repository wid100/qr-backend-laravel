<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Resume;  // Assuming your model is Resume
use PDF; // DomPDF Facade for generating PDFs
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class ResumeController extends Controller
{
    // Function to generate and download the PDF
    public function generatePdf($userId, $templateId)
    {
        // Fetch the resume data
        $resume = Resume::where('user_id', $userId)->firstOrFail();

        // Define the path where your templates are stored
        $templatePath = resource_path("views/resume/templates/template{$templateId}.blade.php");

        // Check if the template file exists
        if (!File::exists($templatePath)) {
            abort(404, "Template not found");
        }

        // View name based on templateId
        $viewName = "resume.templates.template{$templateId}";

        // Generate the PDF
        $pdf = PDF::loadView($viewName, compact('resume'));

        // Return the PDF as a download
        return $pdf->download('resume_' . $userId . '.pdf');
    }

    // Function to view the PDF in the browser
    public function viewPdf($userId, $templateId)
    {
        // Fetch the resume data for the given user
        $resume = Resume::where('user_id', $userId)->firstOrFail();

        // Define the path where your templates are stored
        $templatePath = resource_path("views/resume/templates/template{$templateId}.blade.php");

        // Check if the template file exists
        if (!File::exists($templatePath)) {
            abort(404, "Template not found");
        }

        // View name based on templateId
        $viewName = "resume.templates.template{$templateId}";

        // Generate the PDF using the template and data
        $pdf = PDF::loadView($viewName, compact('resume'));

        // Return the PDF as a stream to the browser (for viewing)
        return $pdf->stream('resume_' . $userId . '.pdf');
    }
}
