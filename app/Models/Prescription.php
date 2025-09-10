<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'prescription_number',
        'prescription_date',
        'doctor_name',
        'doctor_license',
        'clinic_name',
        'diagnosis',
        'symptoms',
        'notes',
        'medicines',
        'dosage_instructions',
        'original_image_path',
        'processed_image_path',
        'ocr_data',
        'is_verified',
        'verified_at',
    ];

    protected $casts = [
        'prescription_date' => 'date',
        'medicines' => 'array',
        'dosage_instructions' => 'array',
        'ocr_data' => 'array',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    // Relationships
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    // Helper methods
    public static function generatePrescriptionNumber(): string
    {
        do {
            $prescriptionNumber = 'RX' . date('Ymd') . strtoupper(Str::random(4));
        } while (self::where('prescription_number', $prescriptionNumber)->exists());

        return $prescriptionNumber;
    }

    public function verify(): void
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }

    public function getFormattedMedicines(): array
    {
        return collect($this->medicines)->map(function ($medicine) {
            return [
                'name' => $medicine['name'] ?? '',
                'dosage' => $medicine['dosage'] ?? '',
                'frequency' => $medicine['frequency'] ?? '',
                'duration' => $medicine['duration'] ?? '',
                'instructions' => $medicine['instructions'] ?? '',
            ];
        })->toArray();
    }
}
