<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Resume;
use PDF;

class ResumeController extends Controller
{
    public function generatePdf($userId, $templateId)
    {
        // Fetch the resume data for the given user
        $resume = Resume::where('user_id', $userId)->firstOrFail();

        // Decode the JSON data for education and skills, or default to an empty array
        $education = json_decode($resume->education, true) ?? [];
        $experiences = json_decode($resume->experience, true) ?? [];
        $skills = json_decode($resume->skill, true);
        $languages = json_decode($resume->language, true);
        $interestes = json_decode($resume->interest, true);
        $references = json_decode($resume->references, true) ?? [];

        // Convert image to base64 if needed
        if ($resume->photo) {
            $imagePath = public_path($resume->photo);  // Get the local image path
            if (file_exists($imagePath)) {
                // Get image type and content
                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imageData = file_get_contents($imagePath);
                // Convert to base64 encoding
                $base64Image = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);
            } else {
                $base64Image = null;  // Handle case where image doesn't exist
            }
        } else {
            $base64Image = null;  // Handle case where there's no image
        }

        // View name based on templateId
        $viewName = "resume.templates.template{$templateId}";

        // Generate the PDF using the template and data (including education and skills)
        $pdf = PDF::loadView($viewName, compact('resume', 'education', 'references', 'skills', 'interestes', 'experiences', 'languages', 'base64Image'))
            ->setPaper('a4', 'portrait') // A4 size in portrait
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        // Return the PDF as a download
        return $pdf->download('resume_' . $userId . '.pdf');
    }

    public function viewPdf($userId, $templateId)
    {
        // Fetch the resume data for the given user
        $resume = Resume::where('user_id', $userId)->firstOrFail();

        // Decode the JSON data for education and skills, or default to an empty array
        $education = json_decode($resume->education, true) ?? [];
        $experiences = json_decode($resume->experience, true) ?? [];
        $skills = json_decode($resume->skill, true);
        $languages = json_decode($resume->language, true);
        $interestes = json_decode($resume->interest, true);
        $references = json_decode($resume->references, true) ?? [];

        // Convert image to base64 if needed
        if ($resume->photo) {
            $imagePath = public_path($resume->photo);  // Get the local image path
            if (file_exists($imagePath)) {
                // Get image type and content
                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imageData = file_get_contents($imagePath);
                // Convert to base64 encoding
                $base64Image = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);
            } else {
                $base64Image = null;  // Handle case where image doesn't exist
            }
        } else {
            $base64Image = null;  // Handle case where there's no image
        }

        // View name based on templateId
        $viewName = "resume.templates.template{$templateId}";

        // Generate the PDF using the template and data (including education and skills)
        $pdf = PDF::loadView($viewName, compact('resume', 'education', 'references', 'skills', 'interestes', 'experiences', 'languages', 'base64Image'))
            ->setPaper('a4', 'portrait') // A4 size in portrait
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        // Return the PDF as a stream to the browser
        return $pdf->stream('resume_' . $userId . '.pdf');
    }
}
