<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class MedicalReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'report_number',
        'report_type',
        'test_date',
        'lab_name',
        'doctor_name',
        'test_notes',
        'test_results',
        'normal_ranges',
        'original_image_path',
        'processed_image_path',
        'ocr_data',
        'is_verified',
        'verified_at',
    ];

    protected $casts = [
        'test_date' => 'date',
        'test_results' => 'array',
        'normal_ranges' => 'array',
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
    public static function generateReportNumber(): string
    {
        do {
            $reportNumber = 'RPT' . date('Ymd') . strtoupper(Str::random(4));
        } while (self::where('report_number', $reportNumber)->exists());

        return $reportNumber;
    }

    public function verify(): void
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }

    public function getFormattedResults(): array
    {
        return collect($this->test_results)->map(function ($result) {
            return [
                'test_name' => $result['test_name'] ?? '',
                'value' => $result['value'] ?? '',
                'unit' => $result['unit'] ?? '',
                'normal_range' => $result['normal_range'] ?? '',
                'status' => $result['status'] ?? 'normal', // normal, high, low, critical
            ];
        })->toArray();
    }

    public function getAbnormalResults(): array
    {
        return collect($this->getFormattedResults())->filter(function ($result) {
            return in_array($result['status'], ['high', 'low', 'critical']);
        })->toArray();
    }
}
