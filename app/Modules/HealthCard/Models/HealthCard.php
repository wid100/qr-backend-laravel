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
        'title',
        'description',
        'qr_code_hash',
        'access_type',
        'meta',
    ];

    protected $casts = [
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
