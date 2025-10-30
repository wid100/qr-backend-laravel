<?php

namespace App\Services;

use App\Models\HealthCard;
use App\Models\Patient;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class HealthCardService
{
    /**
     * Generate a new health card for a patient
     */
    public function generateHealthCard(Patient $patient): HealthCard
    {
        // Generate unique identifiers
        $cardNumber = HealthCard::generateCardNumber();
        $qrCode = HealthCard::generateQRCode();

        // Create QR code data
        $qrData = [
            'card_number' => $cardNumber,
            'patient_id' => $patient->patient_id,
            'patient_name' => $patient->full_name,
            'issued_at' => now()->toISOString(),
            'expires_at' => now()->addYears(5)->toISOString(),
        ];

        // Generate QR code image
        $qrCodeImage = $this->generateQRCodeImage($qrData);

        // Create health card
        $healthCard = HealthCard::create([
            'patient_id' => $patient->id,
            'card_number' => $cardNumber,
            'qr_code' => $qrCode,
            'barcode' => $this->generateBarcode($cardNumber),
            'card_image_path' => $this->saveHealthCardImage($patient, $qrCodeImage),
            'is_active' => true,
            'issued_at' => now(),
            'expires_at' => now()->addYears(5),
        ]);

        return $healthCard;
    }

    /**
     * Generate QR code image - Use SVG format (doesn't require Imagick)
     * SVG works without any image library, just returns XML string
     */
    private function generateQRCodeImage(array $data): string
    {
        try {
            $qrData = json_encode($data);

            // Use SVG format which doesn't require Imagick
            $svgCode = QrCode::format('svg')
                ->size(300)
                ->margin(2)
                ->errorCorrection('H')
                ->generate($qrData);

            // Convert SVG to PNG using GD
            return $this->convertSvgToPng($svgCode, 300);
        } catch (\Exception $e) {
            Log::error('QR Code generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Ultimate fallback: Create a simple PNG with QR code data encoded as text
            return $this->createFallbackQRImage($data);
        }
    }

    /**
     * Convert SVG QR code to PNG using GD
     * Parses SVG and draws it on GD canvas
     */
    private function convertSvgToPng(string $svgCode, int $size): string
    {
        try {
            // Create image
            $image = imagecreatetruecolor($size, $size);

            // White background
            $white = imagecolorallocate($image, 255, 255, 255);
            $black = imagecolorallocate($image, 0, 0, 0);
            imagefill($image, 0, 0, $white);

            // Parse SVG to extract QR code pattern
            // Simple approach: Extract rect elements from SVG and draw them
            preg_match_all('/<rect[^>]*x="([^"]*)"[^>]*y="([^"]*)"[^>]*width="([^"]*)"[^>]*height="([^"]*)"[^>]*fill="([^"]*)"[^>]*\/>/i', $svgCode, $matches, PREG_SET_ORDER);

            $scale = $size / 300; // SVG is 300x300, scale to desired size

            foreach ($matches as $match) {
                if (count($match) >= 6 && $match[5] === '#000000') {
                    $x = (int)($match[1] * $scale);
                    $y = (int)($match[2] * $scale);
                    $w = (int)($match[3] * $scale);
                    $h = (int)($match[4] * $scale);

                    imagefilledrectangle($image, $x, $y, $x + $w, $y + $h, $black);
                }
            }

            // Capture output
            ob_start();
            imagepng($image);
            $pngData = ob_get_contents();
            ob_end_clean();

            imagedestroy($image);

            return $pngData;
        } catch (\Exception $e) {
            Log::warning('SVG to PNG conversion failed', [
                'error' => $e->getMessage()
            ]);
            // Return empty string, will use fallback
            return '';
        }
    }

    /**
     * Create a fallback QR code image when SVG conversion fails
     */
    private function createFallbackQRImage(array $data): string
    {
        $size = 300;
        $image = imagecreatetruecolor($size, $size);

        // White background
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        imagefill($image, 0, 0, $white);

        // Draw a placeholder QR code pattern
        // Simple checkerboard pattern as fallback
        $blockSize = 10;
        for ($y = 0; $y < $size; $y += $blockSize) {
            for ($x = 0; $x < $size; $x += $blockSize) {
                if (($x / $blockSize + $y / $blockSize) % 2 == 0) {
                    imagefilledrectangle($image, $x, $y, $x + $blockSize, $y + $blockSize, $black);
                }
            }
        }

        // Add text
        $text = 'QR Code';
        $textX = ($size - imagefontwidth(5) * strlen($text)) / 2;
        $textY = ($size - imagefontheight(5)) / 2;
        imagestring($image, 5, $textX, $textY, $text, $white);

        // Capture output
        ob_start();
        imagepng($image);
        $pngData = ob_get_contents();
        ob_end_clean();

        imagedestroy($image);

        return $pngData;
    }

    /**
     * Generate barcode data
     */
    private function generateBarcode(string $cardNumber): string
    {
        // Simple barcode generation (you can use a barcode library for better results)
        return 'BAR' . $cardNumber . 'END';
    }

    /**
     * Save health card image to storage
     */
    private function saveHealthCardImage(Patient $patient, string $qrCodeImage): ?string
    {
        try {
            // Ensure directory exists
            $directory = 'health-cards';
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            $filename = $directory . '/' . $patient->patient_id . '_' . time() . '.png';

            Storage::disk('public')->put($filename, $qrCodeImage);

            return $filename;
        } catch (\Exception $e) {
            Log::error('Failed to save health card image', [
                'patient_id' => $patient->id,
                'error' => $e->getMessage(),
            ]);
            // Return null instead of throwing - card can still be created without image
            return null;
        }
    }

    /**
     * Get health card by QR code
     */
    public function getHealthCardByQRCode(string $qrCode): ?HealthCard
    {
        return HealthCard::where('qr_code', $qrCode)
            ->where('is_active', true)
            ->with(['patient.user', 'patient.prescriptions', 'patient.medicalReports'])
            ->first();
    }

    /**
     * Get health card by card number
     */
    public function getHealthCardByCardNumber(string $cardNumber): ?HealthCard
    {
        return HealthCard::where('card_number', $cardNumber)
            ->where('is_active', true)
            ->with(['patient.user', 'patient.prescriptions', 'patient.medicalReports'])
            ->first();
    }

    /**
     * Get patient medical history
     */
    public function getPatientMedicalHistory(Patient $patient): array
    {
        return [
            'patient' => [
                'id' => $patient->id,
                'patient_id' => $patient->patient_id,
                'name' => $patient->full_name,
                'age' => $patient->age,
                'gender' => $patient->gender,
                'blood_type' => $patient->blood_type,
                'allergies' => $patient->allergies,
                'medical_history' => $patient->medical_history,
                'current_medications' => $patient->current_medications,
            ],
            'prescriptions' => $patient->prescriptions()
                ->with('doctor')
                ->orderBy('prescription_date', 'desc')
                ->get()
                ->map(function ($prescription) {
                    return [
                        'id' => $prescription->id,
                        'prescription_number' => $prescription->prescription_number,
                        'date' => $prescription->prescription_date->format('Y-m-d'),
                        'doctor_name' => $prescription->doctor_name,
                        'diagnosis' => $prescription->diagnosis,
                        'medicines' => $prescription->getFormattedMedicines(),
                        'is_verified' => $prescription->is_verified,
                    ];
                }),
            'medical_reports' => $patient->medicalReports()
                ->with('doctor')
                ->orderBy('test_date', 'desc')
                ->get()
                ->map(function ($report) {
                    return [
                        'id' => $report->id,
                        'report_number' => $report->report_number,
                        'type' => $report->report_type,
                        'date' => $report->test_date->format('Y-m-d'),
                        'lab_name' => $report->lab_name,
                        'results' => $report->getFormattedResults(),
                        'abnormal_results' => $report->getAbnormalResults(),
                        'is_verified' => $report->is_verified,
                    ];
                }),
        ];
    }

    /**
     * Validate QR code data
     */
    public function validateQRCode(string $qrCode): bool
    {
        $healthCard = $this->getHealthCardByQRCode($qrCode);

        if (!$healthCard) {
            return false;
        }

        // Check if card is expired
        if ($healthCard->isExpired()) {
            return false;
        }

        return true;
    }

    /**
     * Deactivate health card
     */
    public function deactivateHealthCard(HealthCard $healthCard): bool
    {
        return $healthCard->update(['is_active' => false]);
    }

    /**
     * Reactivate health card
     */
    public function reactivateHealthCard(HealthCard $healthCard): bool
    {
        return $healthCard->update(['is_active' => true]);
    }
}
