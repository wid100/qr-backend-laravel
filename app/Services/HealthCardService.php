<?php

namespace App\Services;

use App\Models\HealthCard;
use App\Models\Patient;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
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
     * Generate QR code image
     */
    private function generateQRCodeImage(array $data): string
    {
        $qrData = json_encode($data);

        return QrCode::format('png')
            ->size(300)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($qrData);
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
    private function saveHealthCardImage(Patient $patient, string $qrCodeImage): string
    {
        $filename = 'health-cards/' . $patient->patient_id . '_' . time() . '.png';

        Storage::disk('public')->put($filename, $qrCodeImage);

        return $filename;
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
