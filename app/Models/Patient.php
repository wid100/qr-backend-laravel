<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone',
        'address',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

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

    public static function generatePatientId(): string
    {
        do {
            $patientId = 'PAT' . date('Ymd') . strtoupper(Str::random(4));
        } while (self::where('patient_id', $patientId)->exists());

        return $patientId;
    }

    public static function findOrCreateForUser(User $user): self
    {
        $patient = self::where('user_id', $user->id)->first();

        if ($patient) {
            return $patient;
        }

        $nameParts = preg_split('/\s+/', trim($user->name), 2);

        return self::create([
            'user_id'    => $user->id,
            'patient_id' => self::generatePatientId(),
            'first_name' => $nameParts[0] ?? $user->name,
            'last_name'  => $nameParts[1] ?? null,
            'is_active'  => true,
        ]);
    }
}
