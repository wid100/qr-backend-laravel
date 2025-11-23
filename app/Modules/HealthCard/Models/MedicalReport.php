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
    ];

    /**
     * Relationship: MedicalReport belongs to HealthCard
     */
    public function healthCard(): BelongsTo
    {
        return $this->belongsTo(HealthCard::class, 'health_card_id');
    }
}

