<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'first_name',
        'last_name',
        'license_number',
        'specialization',
        'qualification',
        'phone',
        'email',
        'address',
        'clinic_name',
        'clinic_address',
        'experience_years',
        'available_days',
        'start_time',
        'end_time',
        'is_active',
    ];

    protected $casts = [
        'available_days' => 'array',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    public function medicalReports(): HasMany
    {
        return $this->hasMany(MedicalReport::class);
    }

    // Helper methods
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function generateDoctorId(): string
    {
        do {
            $doctorId = 'DR' . date('Y') . strtoupper(Str::random(6));
        } while (self::where('doctor_id', $doctorId)->exists());

        return $doctorId;
    }

    public function isAvailableOnDay(string $day): bool
    {
        return in_array($day, $this->available_days ?? []);
    }

    public function getWorkingHours(): string
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }
}
