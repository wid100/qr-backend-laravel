<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class OCRService
{
    /**
     * Extract text from prescription image using OCR
     */
    public function extractPrescriptionData(UploadedFile $image): array
    {
        // Save uploaded image temporarily
        $imagePath = $image->store('temp/ocr', 'public');
        $fullPath = Storage::disk('public')->path($imagePath);

        try {
            // Extract text using OCR
            $extractedText = $this->performOCR($fullPath);

            // Parse prescription data from extracted text
            $prescriptionData = $this->parsePrescriptionText($extractedText);

            // Clean up temporary file
            Storage::disk('public')->delete($imagePath);

            return $prescriptionData;
        } catch (\Exception $e) {
            // Clean up on error
            Storage::disk('public')->delete($imagePath);
            throw $e;
        }
    }

    /**
     * Extract text from medical report image using OCR
     */
    public function extractMedicalReportData(UploadedFile $image): array
    {
        // Save uploaded image temporarily
        $imagePath = $image->store('temp/ocr', 'public');
        $fullPath = Storage::disk('public')->path($imagePath);

        try {
            // Extract text using OCR
            $extractedText = $this->performOCR($fullPath);

            // Parse medical report data from extracted text
            $reportData = $this->parseMedicalReportText($extractedText);

            // Clean up temporary file
            Storage::disk('public')->delete($imagePath);

            return $reportData;
        } catch (\Exception $e) {
            // Clean up on error
            Storage::disk('public')->delete($imagePath);
            throw $e;
        }
    }

    /**
     * Perform OCR on image file
     */
    private function performOCR(string $imagePath): string
    {
        // For now, we'll use a simple approach
        // In production, you would integrate with Google Vision API, Tesseract, or similar

        // This is a placeholder - you would implement actual OCR here
        // For example, using Google Vision API:

        /*
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.google.vision_api_key'),
        ])->post('https://vision.googleapis.com/v1/images:annotate', [
            'requests' => [
                [
                    'image' => [
                        'content' => base64_encode(file_get_contents($imagePath))
                    ],
                    'features' => [
                        ['type' => 'TEXT_DETECTION']
                    ]
                ]
            ]
        ]);

        $data = $response->json();
        return $data['responses'][0]['textAnnotations'][0]['description'] ?? '';
        */

        // Placeholder return for now
        return "Sample extracted text from prescription image";
    }

    /**
     * Parse prescription text to extract structured data
     */
    private function parsePrescriptionText(string $text): array
    {
        // This is a simplified parser - in production, you would use more sophisticated NLP
        $data = [
            'doctor_name' => $this->extractDoctorName($text),
            'clinic_name' => $this->extractClinicName($text),
            'prescription_date' => $this->extractDate($text),
            'diagnosis' => $this->extractDiagnosis($text),
            'symptoms' => $this->extractSymptoms($text),
            'medicines' => $this->extractMedicines($text),
            'notes' => $this->extractNotes($text),
            'raw_text' => $text,
        ];

        return $data;
    }

    /**
     * Parse medical report text to extract structured data
     */
    private function parseMedicalReportText(string $text): array
    {
        $data = [
            'report_type' => $this->extractReportType($text),
            'lab_name' => $this->extractLabName($text),
            'test_date' => $this->extractDate($text),
            'doctor_name' => $this->extractDoctorName($text),
            'test_results' => $this->extractTestResults($text),
            'normal_ranges' => $this->extractNormalRanges($text),
            'test_notes' => $this->extractTestNotes($text),
            'raw_text' => $text,
        ];

        return $data;
    }

    /**
     * Extract doctor name from text
     */
    private function extractDoctorName(string $text): string
    {
        // Simple regex patterns to find doctor names
        $patterns = [
            '/Dr\.?\s+([A-Z][a-z]+(?:\s+[A-Z][a-z]+)*)/',
            '/Doctor\s+([A-Z][a-z]+(?:\s+[A-Z][a-z]+)*)/',
            '/Name:\s*([A-Z][a-z]+(?:\s+[A-Z][a-z]+)*)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                return trim($matches[1]);
            }
        }

        return '';
    }

    /**
     * Extract clinic name from text
     */
    private function extractClinicName(string $text): string
    {
        $patterns = [
            '/Clinic:\s*([^\n\r]+)/i',
            '/Hospital:\s*([^\n\r]+)/i',
            '/Center:\s*([^\n\r]+)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                return trim($matches[1]);
            }
        }

        return '';
    }

    /**
     * Extract date from text
     */
    private function extractDate(string $text): string
    {
        $patterns = [
            '/(\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4})/',
            '/(\d{4}[-\/]\d{1,2}[-\/]\d{1,2})/',
            '/(\d{1,2}\s+(?:Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*\s+\d{4})/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                return trim($matches[1]);
            }
        }

        return '';
    }

    /**
     * Extract diagnosis from text
     */
    private function extractDiagnosis(string $text): string
    {
        $patterns = [
            '/Diagnosis:\s*([^\n\r]+)/i',
            '/Dx:\s*([^\n\r]+)/i',
            '/Condition:\s*([^\n\r]+)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                return trim($matches[1]);
            }
        }

        return '';
    }

    /**
     * Extract symptoms from text
     */
    private function extractSymptoms(string $text): string
    {
        $patterns = [
            '/Symptoms:\s*([^\n\r]+)/i',
            '/Complaints:\s*([^\n\r]+)/i',
            '/Chief Complaint:\s*([^\n\r]+)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                return trim($matches[1]);
            }
        }

        return '';
    }

    /**
     * Extract medicines from text
     */
    private function extractMedicines(string $text): array
    {
        $medicines = [];

        // Simple medicine extraction - in production, use more sophisticated NLP
        $lines = explode("\n", $text);

        foreach ($lines as $line) {
            $line = trim($line);

            // Look for medicine patterns
            if (preg_match('/([A-Z][a-z]+(?:\s+[A-Z][a-z]+)*)\s+(\d+\s*(?:mg|g|ml|tablet|tab|cap|capsule)s?)\s*(.*)/i', $line, $matches)) {
                $medicines[] = [
                    'name' => trim($matches[1]),
                    'dosage' => trim($matches[2]),
                    'instructions' => trim($matches[3]),
                    'frequency' => $this->extractFrequency($line),
                    'duration' => $this->extractDuration($line),
                ];
            }
        }

        return $medicines;
    }

    /**
     * Extract test results from text
     */
    private function extractTestResults(string $text): array
    {
        $results = [];

        // Look for test result patterns
        $lines = explode("\n", $text);

        foreach ($lines as $line) {
            $line = trim($line);

            // Pattern: Test Name: Value Unit (Normal Range)
            if (preg_match('/([A-Za-z\s]+):\s*([0-9.]+)\s*([A-Za-z%\/]+)\s*\(([0-9.-]+)\s*-\s*([0-9.-]+)\)/i', $line, $matches)) {
                $results[] = [
                    'test_name' => trim($matches[1]),
                    'value' => floatval($matches[2]),
                    'unit' => trim($matches[3]),
                    'normal_range' => trim($matches[4]) . ' - ' . trim($matches[5]),
                    'status' => $this->determineTestStatus(floatval($matches[2]), floatval($matches[4]), floatval($matches[5])),
                ];
            }
        }

        return $results;
    }

    /**
     * Extract normal ranges from text
     */
    private function extractNormalRanges(string $text): array
    {
        // This would extract normal ranges for different tests
        // For now, return empty array
        return [];
    }

    /**
     * Extract notes from text
     */
    private function extractNotes(string $text): string
    {
        $patterns = [
            '/Notes:\s*([^\n\r]+)/i',
            '/Remarks:\s*([^\n\r]+)/i',
            '/Comments:\s*([^\n\r]+)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                return trim($matches[1]);
            }
        }

        return '';
    }

    /**
     * Extract report type from text
     */
    private function extractReportType(string $text): string
    {
        $types = ['blood_test', 'xray', 'mri', 'ct_scan', 'ultrasound', 'ecg', 'urine_test'];

        foreach ($types as $type) {
            if (stripos($text, $type) !== false) {
                return $type;
            }
        }

        return 'blood_test'; // Default
    }

    /**
     * Extract lab name from text
     */
    private function extractLabName(string $text): string
    {
        $patterns = [
            '/Lab:\s*([^\n\r]+)/i',
            '/Laboratory:\s*([^\n\r]+)/i',
            '/Pathology:\s*([^\n\r]+)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                return trim($matches[1]);
            }
        }

        return '';
    }

    /**
     * Extract test notes from text
     */
    private function extractTestNotes(string $text): string
    {
        return $this->extractNotes($text);
    }

    /**
     * Extract frequency from medicine line
     */
    private function extractFrequency(string $line): string
    {
        $patterns = [
            '/(\d+\s*(?:times?|x)\s*(?:daily|day|week|month))/i',
            '/((?:once|twice|thrice)\s*(?:daily|day|week|month))/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $line, $matches)) {
                return trim($matches[1]);
            }
        }

        return '';
    }

    /**
     * Extract duration from medicine line
     */
    private function extractDuration(string $line): string
    {
        $patterns = [
            '/(\d+\s*(?:days?|weeks?|months?|years?))/i',
            '/(for\s+\d+\s*(?:days?|weeks?|months?|years?))/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $line, $matches)) {
                return trim($matches[1]);
            }
        }

        return '';
    }

    /**
     * Determine test status based on value and normal range
     */
    private function determineTestStatus(float $value, float $min, float $max): string
    {
        if ($value < $min) {
            return 'low';
        } elseif ($value > $max) {
            return 'high';
        } else {
            return 'normal';
        }
    }
}
