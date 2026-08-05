<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class OCRService
{
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * Extract structured prescription data from an UploadedFile.
     */
    public function extractPrescriptionData(UploadedFile $image): array
    {
        return $this->withTempFile($image, function (string $fullPath, string $mime) {
            return $this->analyzePrescriptionPath($fullPath, $mime);
        });
    }

    /**
     * Extract structured medical report data from an UploadedFile.
     */
    public function extractMedicalReportData(UploadedFile $image): array
    {
        return $this->withTempFile($image, function (string $fullPath, string $mime) {
            return $this->analyzeMedicalReportPath($fullPath, $mime);
        });
    }

    /**
     * Extract health-visit form fields from an UploadedFile.
     */
    public function extractHealthCardVisitData(UploadedFile $image): array
    {
        return $this->withTempFile($image, function (string $fullPath, string $mime) {
            return $this->analyzeHealthVisitPath($fullPath, $mime);
        });
    }

    /**
     * Analyze a file already stored on the public disk (relative path).
     */
    public function extractPrescriptionFromStored(string $relativePath): array
    {
        $fullPath = $this->resolvePath($relativePath);
        $mime = mime_content_type($fullPath) ?: 'application/octet-stream';

        return $this->analyzePrescriptionPath($fullPath, $mime);
    }

    public function extractMedicalReportFromStored(string $relativePath): array
    {
        $fullPath = $this->resolvePath($relativePath);
        $mime = mime_content_type($fullPath) ?: 'application/octet-stream';

        return $this->analyzeMedicalReportPath($fullPath, $mime);
    }

    protected function analyzePrescriptionPath(string $fullPath, string $mime): array
    {
        $prompt = <<<'PROMPT'
You are a medical document OCR assistant. Extract prescription data from this image/PDF.
Return ONLY valid JSON with this exact shape:
{
  "doctor_name": "",
  "clinic_name": "",
  "prescription_date": "YYYY-MM-DD or empty string",
  "diagnosis": "",
  "symptoms": "",
  "medicines": [
    {
      "name": "",
      "dosage": "",
      "frequency": "",
      "duration": "",
      "instructions": ""
    }
  ],
  "notes": "",
  "raw_text": "full extracted text"
}
Rules:
- Prefer ISO date YYYY-MM-DD when a date is visible.
- If a field is unknown, use "" or [] as appropriate.
- Do not invent medicines that are not on the document.
PROMPT;

        $data = $this->gemini->analyzeFileJson($fullPath, $prompt, $mime, [
            'temperature' => 0.1,
            'max_output_tokens' => 4096,
        ]);

        return $this->normalizePrescription($data);
    }

    protected function analyzeMedicalReportPath(string $fullPath, string $mime): array
    {
        $prompt = <<<'PROMPT'
You are a medical document OCR assistant. Extract lab/medical report data from this image/PDF.
Return ONLY valid JSON with this exact shape:
{
  "report_type": "blood_test|xray|mri|ct_scan|ultrasound|ecg|urine_test|other or short label",
  "lab_name": "",
  "test_date": "YYYY-MM-DD or empty string",
  "doctor_name": "",
  "test_results": [
    {
      "test_name": "",
      "value": "",
      "unit": "",
      "normal_range": "",
      "status": "normal|high|low|critical|unknown"
    }
  ],
  "normal_ranges": {},
  "test_notes": "",
  "raw_text": "full extracted text"
}
Rules:
- Prefer ISO date YYYY-MM-DD when a date is visible.
- If a field is unknown, use "" / [] / {} as appropriate.
- Do not invent test results that are not on the document.
PROMPT;

        $data = $this->gemini->analyzeFileJson($fullPath, $prompt, $mime, [
            'temperature' => 0.1,
            'max_output_tokens' => 4096,
        ]);

        return $this->normalizeMedicalReport($data);
    }

    protected function analyzeHealthVisitPath(string $fullPath, string $mime): array
    {
        $prompt = <<<'PROMPT'
You are a medical document OCR assistant for a health card app.
Extract visit / prescription / report details from this image/PDF.
Return ONLY valid JSON with this exact shape:
{
  "visit_date": "YYYY-MM-DD or empty string",
  "doctor_name": "",
  "specialty": "",
  "hospital_name": "",
  "phone": "",
  "recommendations": "",
  "tests": [
    { "test_name": "", "result": "" }
  ],
  "medicines": [
    {
      "medicine_name": "",
      "dosage": "",
      "duration": "",
      "timing": { "morning": false, "noon": false, "night": false }
    }
  ],
  "diet_routines": [
    { "time": "", "food_items": "" }
  ],
  "raw_text": "full extracted text"
}
Rules:
- Infer medicine timing only when the document clearly indicates morning/noon/night (or BD conventions like সকাল/দুপুর/রাত).
- Prefer ISO date YYYY-MM-DD.
- Do not invent clinical data.
PROMPT;

        $data = $this->gemini->analyzeFileJson($fullPath, $prompt, $mime, [
            'temperature' => 0.1,
            'max_output_tokens' => 4096,
        ]);

        return [
            'visit_date' => (string) ($data['visit_date'] ?? ''),
            'doctor_name' => (string) ($data['doctor_name'] ?? ''),
            'specialty' => (string) ($data['specialty'] ?? ''),
            'hospital_name' => (string) ($data['hospital_name'] ?? ''),
            'phone' => (string) ($data['phone'] ?? ''),
            'recommendations' => (string) ($data['recommendations'] ?? ''),
            'tests' => is_array($data['tests'] ?? null) ? $data['tests'] : [],
            'medicines' => is_array($data['medicines'] ?? null) ? $data['medicines'] : [],
            'diet_routines' => is_array($data['diet_routines'] ?? null) ? $data['diet_routines'] : [],
            'raw_text' => (string) ($data['raw_text'] ?? ''),
        ];
    }

    protected function withTempFile(UploadedFile $image, callable $callback): array
    {
        if (! $this->gemini->isConfigured()) {
            throw new RuntimeException('Gemini API key is not configured.');
        }

        $imagePath = $image->store('temp/ocr', 'public');
        $fullPath = Storage::disk('public')->path($imagePath);
        $mime = $image->getMimeType() ?: (mime_content_type($fullPath) ?: 'application/octet-stream');

        try {
            return $callback($fullPath, $mime);
        } catch (\Throwable $e) {
            Log::error('OCR extraction failed', [
                'error' => $e->getMessage(),
            ]);
            throw $e;
        } finally {
            Storage::disk('public')->delete($imagePath);
        }
    }

    protected function resolvePath(string $path): string
    {
        if (is_file($path)) {
            return $path;
        }

        $publicPath = Storage::disk('public')->path($path);
        if (is_file($publicPath)) {
            return $publicPath;
        }

        throw new RuntimeException('OCR source file not found.');
    }

    protected function normalizePrescription(array $data): array
    {
        $medicines = [];
        foreach (($data['medicines'] ?? []) as $med) {
            if (! is_array($med)) {
                continue;
            }
            $medicines[] = [
                'name' => (string) ($med['name'] ?? ''),
                'dosage' => (string) ($med['dosage'] ?? ''),
                'frequency' => (string) ($med['frequency'] ?? ''),
                'duration' => (string) ($med['duration'] ?? ''),
                'instructions' => (string) ($med['instructions'] ?? ''),
            ];
        }

        return [
            'doctor_name' => (string) ($data['doctor_name'] ?? ''),
            'clinic_name' => (string) ($data['clinic_name'] ?? ''),
            'prescription_date' => (string) ($data['prescription_date'] ?? ''),
            'diagnosis' => (string) ($data['diagnosis'] ?? ''),
            'symptoms' => (string) ($data['symptoms'] ?? ''),
            'medicines' => $medicines,
            'notes' => (string) ($data['notes'] ?? ''),
            'raw_text' => (string) ($data['raw_text'] ?? ''),
        ];
    }

    protected function normalizeMedicalReport(array $data): array
    {
        $results = [];
        foreach (($data['test_results'] ?? []) as $row) {
            if (! is_array($row)) {
                continue;
            }
            $results[] = [
                'test_name' => (string) ($row['test_name'] ?? ''),
                'value' => $row['value'] ?? '',
                'unit' => (string) ($row['unit'] ?? ''),
                'normal_range' => (string) ($row['normal_range'] ?? ''),
                'status' => (string) ($row['status'] ?? 'unknown'),
            ];
        }

        return [
            'report_type' => (string) ($data['report_type'] ?? 'other'),
            'lab_name' => (string) ($data['lab_name'] ?? ''),
            'test_date' => (string) ($data['test_date'] ?? ''),
            'doctor_name' => (string) ($data['doctor_name'] ?? ''),
            'test_results' => $results,
            'normal_ranges' => is_array($data['normal_ranges'] ?? null) ? $data['normal_ranges'] : [],
            'test_notes' => (string) ($data['test_notes'] ?? ''),
            'raw_text' => (string) ($data['raw_text'] ?? ''),
        ];
    }
}
