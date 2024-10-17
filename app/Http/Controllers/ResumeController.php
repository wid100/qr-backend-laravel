<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Resume;
use Barryvdh\DomPDF\Facade\Pdf;



class ResumeController extends Controller
{
    public function generatePdf($userId, $templateId)
    {
        // Fetch the resume data for the given user
        $resume = Resume::where('user_id', $userId)->firstOrFail();

        // Decode the JSON data for education, experiences, skills, languages, interests, and references, or default to an empty array
        $education = json_decode($resume->education, true) ?? [];
        $experiences = json_decode($resume->experience, true) ?? [];
        $skills = json_decode($resume->skill, true) ?? [];
        $languages = json_decode($resume->language, true) ?? [];
        $interestes = json_decode($resume->interest, true) ?? [];
        $references = json_decode($resume->references, true) ?? [];

        // Convert image to base64 if it exists
        if ($resume->photo) {
            $imagePath = public_path($resume->photo);
            if (file_exists($imagePath)) {
                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imageData = file_get_contents($imagePath);
                $base64Image = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);
            } else {
                $base64Image = null;
            }
        } else {
            $base64Image = null;
        }

        // Determine the view name based on templateId
        $viewName = "resume.templates.template{$templateId}";

        // Check if the view exists
        if (!view()->exists($viewName)) {
            abort(404, 'Template not found.');
        }

        // Generate the PDF using the template and resume data
        try {
            $pdf = PDF::loadView($viewName, compact('resume', 'education', 'references', 'skills', 'interestes', 'experiences', 'languages', 'base64Image'))
                ->setPaper('a4', 'portrait'); // A4 size in portrait

            // Return the generated PDF as a download
            return $pdf->download('resume_' . $userId . '.pdf');
        } catch (\Exception $e) {
            // Handle any exceptions during PDF generation
            return response()->json(['error' => 'Failed to generate PDF: ' . $e->getMessage()], 500);
        }
    }


    public function viewPdf($userId, $templateId)
    {
        // Fetch the resume data for the given user
        $resume = Resume::where('user_id', $userId)->firstOrFail();

        // Decode the JSON data for education, experiences, skills, languages, interests, and references, or default to an empty array if null
        $education = json_decode($resume->education, true) ?? [];
        $experiences = json_decode($resume->experience, true) ?? [];
        $skills = json_decode($resume->skill, true) ?? [];
        $languages = json_decode($resume->language, true) ?? [];
        $interestes = json_decode($resume->interest, true) ?? [];
        $references = json_decode($resume->references, true) ?? [];

        // Convert image to base64 if it exists
        if ($resume->photo) {
            $imagePath = public_path($resume->photo);
            if (file_exists($imagePath)) {
                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imageData = file_get_contents($imagePath);
                $base64Image = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);
            } else {
                $base64Image = null;
            }
        } else {
            $base64Image = null;
        }

        // Determine the view name based on templateId
        $viewName = "resume.templates.template{$templateId}";

        // Check if the view exists
        if (!view()->exists($viewName)) {
            abort(404, 'Template not found.');
        }

        // Render the HTML view for debugging
        return view($viewName, compact('resume', 'education', 'references', 'skills', 'interestes', 'experiences', 'languages', 'base64Image'));
    }
}
