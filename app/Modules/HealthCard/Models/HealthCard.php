<?php

namespace App\Modules\HealthCard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class HealthCard extends Model
{
    use HasFactory;

    protected $table = 'health_cards';

    protected $fillable = [
        'user_id',
        'person_name',
        'person_photo',
        'date_of_birth',
        'blood_group',
        'gender',
        'card_type',
        'expected_delivery_date',
        'emergency_contact',
        'allergies',
        'slug',
        'username',
        'qr_code_hash',
        'access_type',
        'meta',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'expected_delivery_date' => 'date',
        'meta' => 'array',
    ];

    /**
     * Relationship: HealthCard belongs to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Relationship: HealthCard has many MedicalReports
     */
    public function medicalReports()
    {
        return $this->hasMany(\App\Modules\HealthCard\Models\MedicalReport::class, 'health_card_id');
    }

    /**
     * Generate a unique slug
     */
    public static function generateSlug(string $personName): string
    {
        $baseSlug = Str::slug($personName);
        $slug = $baseSlug;
        $counter = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Generate a unique QR code hash
     * Uses HMAC with app key for cryptographic strength
     */
    public static function generateQrCodeHash(): string
    {
        do {
            $randomString = Str::random(40);
            $hash = hash_hmac('sha256', $randomString, config('app.key'));
        } while (self::where('qr_code_hash', $hash)->exists());

        return $hash;
    }

    /**
     * Check if card is accessible (for non-owner access)
     */
    public function isAccessible(): bool
    {
        if ($this->access_type === 'public') {
            return true;
        }

        if ($this->access_type === 'protected') {
            // Protected cards can be viewed by authenticated users
            return auth()->check();
        }

        // Private cards can only be viewed by owner
        return false;
    }

    /**
     * Get QR code URL
     */
    public function getQrCodeUrlAttribute(): string
    {
        return url("/api/healthcards/qr/{$this->qr_code_hash}");
    }
}
