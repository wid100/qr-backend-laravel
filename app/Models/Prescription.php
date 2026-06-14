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
        'prescription_number',
        'prescription_date',
        'doctor_name',
        'clinic_name',
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

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public static function generatePrescriptionNumber(): string
    {
        do {
            $number = 'RX' . date('Ymd') . strtoupper(Str::random(4));
        } while (self::where('prescription_number', $number)->exists());

        return $number;
    }
}
