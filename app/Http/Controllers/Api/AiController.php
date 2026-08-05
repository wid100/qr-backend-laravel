<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AiController extends Controller
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Extract resume content from an uploaded example CV (PDF/image).
     * POST /api/ai/generate-resume  (multipart: cv_file)
     */
    public function generateResume(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'cv_file' => 'required|file|mimes:jpeg,png,jpg,gif,webp,pdf|max:10240',
            'extra_notes' => 'nullable|string|max:2000',
        ]);

        if (! $this->gemini->isConfigured()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gemini API is not configured on the server.',
            ], 503);
        }

        $file = $request->file('cv_file');
        $absolutePath = $file->getRealPath();
        $mime = $file->getMimeType() ?: 'application/octet-stream';
        $extraNotes = trim((string) ($validated['extra_notes'] ?? ''));

        $notesBlock = $extraNotes !== ''
            ? "Additional user notes to respect while extracting:\n{$extraNotes}\n"
            : '';

        $prompt = <<<PROMPT
You are a resume parser. Read the uploaded CV document carefully and extract ALL visible content into structured JSON for our resume builder.
{$notesBlock}
Return ONLY valid JSON with this exact shape:
{
  "firstName": "",
  "lastName": "",
  "email": "",
  "profession": "",
  "address": "",
  "city": "",
  "postal": "",
  "country": "",
  "phone": "",
  "description": "professional summary as HTML using <p> tags when helpful",
  "jobs": [
    {
      "jobTitle": "",
      "employeeName": "",
      "location": "",
      "startMonth": 1,
      "startYear": 2020,
      "endMonth": 12,
      "endYear": 2022,
      "description": "job responsibilities/achievements, HTML <ul><li> preferred",
      "workingNow": false
    }
  ],
  "education": [
    {
      "institution": "",
      "degree": "",
      "fieldOfStudy": "",
      "startMonth": 1,
      "startYear": 2016,
      "endMonth": 12,
      "endYear": 2020,
      "grade": ""
    }
  ],
  "skills": ["Skill 1"],
  "languages": ["English"],
  "interests": ["Interest"],
  "references": [
    {
      "firstName": "",
      "lastName": "",
      "jobTitle": "",
      "phone": "",
      "email": ""
    }
  ]
}
Rules:
- Extract only information present in the CV. Do NOT invent jobs, companies, degrees, or contact details.
- If a field is missing, use "" / [] / null as appropriate.
- Split full name into firstName and lastName when possible.
- Months must be integers 1-12 or null. Years must be integers or null.
- If a job is current / present, set workingNow=true and endMonth/endYear=null.
- Preserve detail from bullet points into job description HTML.
- skills/languages/interests should be arrays of strings.
PROMPT;

        try {
            $data = $this->gemini->analyzeFileJson($absolutePath, $prompt, $mime, [
                'temperature' => 0.1,
                'max_output_tokens' => 8192,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'CV content extracted successfully',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 502);
        }
    }

    /**
     * Draft an appointment approve / decline message.
     * POST /api/ai/appointment-message
     */
    public function appointmentMessage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'appointment_id' => 'required|integer|exists:appointments,id',
            'type' => 'required|string|in:approve,decline',
            'extra_notes' => 'nullable|string|max:1000',
            'meeting_type' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'meeting_link' => 'nullable|string|max:255',
        ]);

        if (! $this->gemini->isConfigured()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gemini API is not configured on the server.',
            ], 503);
        }

        $appointment = Appointment::findOrFail($validated['appointment_id']);

        if ((int) $appointment->user_id !== (int) Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        $guestName = trim(($appointment->first_name ?? '') . ' ' . ($appointment->last_name ?? ''));
        $type = $validated['type'];
        $extra = $validated['extra_notes'] ?? '';
        $date = $appointment->date;
        $time = is_string($appointment->time_slot)
            ? $appointment->time_slot
            : json_encode($appointment->time_slot);
        $guestMessage = $appointment->message ?? '';
        $location = $validated['location'] ?? ($appointment->location ?? '');
        $meetingLink = $validated['meeting_link'] ?? ($appointment->meeting_link ?? '');
        $meetingType = $validated['meeting_type'] ?? (string) $appointment->meeting_type;

        $actionLabel = $type === 'approve' ? 'APPROVE' : 'DECLINE';

        $prompt = <<<PROMPT
Write a short, polite {$actionLabel} message for an appointment host to send to the guest.
Return ONLY valid JSON: {"message":"..."}

Context:
- Guest name: {$guestName}
- Date: {$date}
- Time slot: {$time}
- Guest's original note: {$guestMessage}
- Meeting type code: {$meetingType}
- Location: {$location}
- Meeting link: {$meetingLink}
- Host extra notes: {$extra}

Rules:
- Length: 2-5 short sentences.
- Friendly professional tone.
- If DECLINE, be courteous and optionally suggest rescheduling without being pushy.
- If APPROVE, confirm details and include meeting location/link when available.
- Do not wrap in markdown.
PROMPT;

        try {
            $data = $this->gemini->generateJson($prompt, [
                'temperature' => 0.6,
                'max_output_tokens' => 512,
            ]);

            $message = trim((string) ($data['message'] ?? ''));
            if ($message === '') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'AI returned an empty message.',
                ], 502);
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'message' => $message,
                ],
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 502);
        }
    }
}
