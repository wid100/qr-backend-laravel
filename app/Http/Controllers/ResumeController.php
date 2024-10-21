<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin\Resume;
use Barryvdh\DomPDF\Facade\Pdf;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ResumeController extends Controller
{
    public function generatePdf($userId, $resumeId, $templateId)
    {
        // Fetch the specific resume for the user
        $resume = Resume::where('user_id', $userId)
            ->where('id', $resumeId)  // Get specific resume by ID
            ->firstOrFail();

        // Decode the JSON data for education, experiences, etc.
        $education = json_decode($resume->education, true) ?? [];
        $experiences = json_decode($resume->experience, true) ?? [];
        $skills = json_decode($resume->skill, true) ?? [];
        $languages = json_decode($resume->language, true) ?? [];
        $interestes = json_decode($resume->interest, true) ?? [];
        $references = json_decode($resume->references, true) ?? [];

        // Convert image to base64 if needed
        $base64Image = null;
        if ($resume->photo) {
            $imagePath = public_path($resume->photo);
            if (file_exists($imagePath)) {
                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imageData = file_get_contents($imagePath);
                $base64Image = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);
            }
        }

        // View name based on templateId
        $viewName = "resume.templates.template{$templateId}";

        // Generate the PDF
        $pdf = PDF::loadView($viewName, compact('resume', 'education', 'references', 'skills', 'interestes', 'experiences', 'languages', 'base64Image'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        // Return the PDF as a download
        return $pdf->download('resume_' . $userId . '_' . $resumeId . '.pdf');
    }

    public function viewPdf($userId, $resumeId, $templateId)
    {
        // Fetch the specific resume for the user
        $resume = Resume::where('user_id', $userId)->firstOrFail()
            ->where('id', $resumeId)  // Get specific resume by ID
            ->firstOrFail();

        // Decode the JSON data for education, experiences, etc.
        $education = json_decode($resume->education, true) ?? [];
        $experiences = json_decode($resume->experience, true) ?? [];
        $skills = json_decode($resume->skill, true) ?? [];
        $languages = json_decode($resume->language, true) ?? [];
        $interestes = json_decode($resume->interest, true) ?? [];
        $references = json_decode($resume->references, true) ?? [];

        // Convert image to base64 if needed
        $base64Image = null;
        if ($resume->photo) {
            $imagePath = public_path($resume->photo);
            if (file_exists($imagePath)) {
                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                $imageData = file_get_contents($imagePath);
                $base64Image = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);
            }
        }

        // Generate the QR code with a link (e.g., resume view link)
        $qrUrl = route('resume.view', ['userId' => $userId, 'resumeId' => $resumeId, 'templateId' => $templateId]);
        $qrCode = QrCode::size(200)->generate($qrUrl);
        // Convert QR code to base64 for embedding in the PDF
        $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCode);

        // View name based on templateId
        $viewName = "resume.templates.template{$templateId}";

        // Generate the PDF
        $pdf = PDF::loadView($viewName, compact('resume', 'education', 'references', 'skills', 'interestes', 'experiences', 'languages', 'base64Image', 'qrCodeBase64'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        // Return the PDF as a stream to view in browser
        return $pdf->stream('resume_' . $userId . '_' . $resumeId . '.pdf');
    }

}
