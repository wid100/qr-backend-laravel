<?php

namespace App\Modules\HealthCard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalReport extends Model
{
    use HasFactory;

    protected $table = 'health_card_medical_reports';

    protected $fillable = [
        'health_card_id',
        'visit_date',
        'doctor_name',
        'hospital_name',
        'medicines',
        'diet_rules',
        'recommendations',
        'test_data',
        'prescription_image',
        'test_report_image',
        'notes',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'test_data' => 'array',
        // Cast prescription_image and test_report_image to array when they are JSON
        // Note: Single images will be strings, multiple images will be arrays
    ];

    /**
     * Get prescription images as array (handles both JSON and string)
     */
    public function getPrescriptionImagesAttribute()
    {
        if (!$this->prescription_image) {
            return [];
        }

        $decoded = json_decode($this->prescription_image, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return [$this->prescription_image];
    }

    /**
     * Get test report images as array (handles both JSON and string)
     */
    public function getTestReportImagesAttribute()
    {
        if (!$this->test_report_image) {
            return [];
        }

        $decoded = json_decode($this->test_report_image, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return [$this->test_report_image];
    }

    /**
     * Relationship: MedicalReport belongs to HealthCard
     */
    public function healthCard(): BelongsTo
    {
        return $this->belongsTo(HealthCard::class, 'health_card_id');
    }
}

